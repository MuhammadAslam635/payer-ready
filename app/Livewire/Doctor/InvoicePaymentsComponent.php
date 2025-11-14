<?php

namespace App\Livewire\Doctor;

use App\Models\PaymentGateway;
use App\Models\UserGatewayPayment;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Notifications\UserPaymentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Invoice Payments')]
#[Layout('layouts.dashboard')]
class InvoicePaymentsComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $showAddModal = false;
    public $showInvoiceModal = false;
    public $selectedInvoice = null;
    public $selectedInvoiceId = '';

    public $selectedGatewayId = '';
    public $transactionId = '';
    public $screenshot = null;

    public $search = '';
    public $invoiceSearch = '';
    public $perPage = 10;

    protected $listeners = [
        'open-invoice-modal' => 'openInvoiceModal',
    ];

    protected function rules(): array
    {
        return [
            'selectedGatewayId' => 'required|exists:payment_gateways,id',
            'selectedInvoiceId' => 'nullable|exists:invoices,id',
            'transactionId' => 'required|string|max:255',
            'screenshot' => 'nullable|image|max:4096',
        ];
    }

    public function openAddModal($invoiceId = null): void
    {
        if ($invoiceId) {
            $invoice = Invoice::where('id', $invoiceId)
                ->where('user_id', Auth::id())
                ->first();
            if ($invoice) {
                $this->selectedInvoiceId = $invoice->id;
            }
        }
        // Don't reset form if invoice is pre-selected
        if (!$invoiceId) {
            $this->resetForm();
        }
        $this->showAddModal = true;
    }

    public function closeAddModal(): void
    {
        $this->showAddModal = false;
        $this->resetForm();
    }

    public function openInvoiceModal($invoiceId): void
    {
        $this->selectedInvoice = Invoice::with(['invoiceItems', 'user'])
            ->where('id', $invoiceId)
            ->where('user_id', Auth::id())
            ->first();
        
        if ($this->selectedInvoice) {
            $this->showInvoiceModal = true;
        }
    }

    public function closeInvoiceModal(): void
    {
        $this->showInvoiceModal = false;
        $this->selectedInvoice = null;
    }

    public function openPayoutFromInvoice($invoiceId = null): void
    {
        $this->closeInvoiceModal();
        
        if ($invoiceId) {
            $invoice = Invoice::where('id', $invoiceId)
                ->where('user_id', Auth::id())
                ->first();
            if ($invoice) {
                $this->selectedInvoiceId = $invoice->id;
                $this->openAddModal($invoiceId);
                return;
            }
        } elseif ($this->selectedInvoice) {
            $this->selectedInvoiceId = $this->selectedInvoice->id;
            $this->openAddModal($this->selectedInvoice->id);
            return;
        }
        
        $this->openAddModal();
    }

    private function resetForm(): void
    {
        $this->selectedGatewayId = '';
        $this->selectedInvoiceId = '';
        $this->transactionId = '';
        $this->screenshot = null;
        $this->resetValidation();
    }

    public function getPendingInvoices()
    {
        return Invoice::with(['invoiceItems'])
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->when($this->invoiceSearch, function ($query) {
                $query->where('invoice_number', 'like', '%' . $this->invoiceSearch . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function save(): void
    {
        $this->validate();

        $screenshotPath = null;
        if ($this->screenshot) {
            try {
                $filename = 'gateway_payment_' . time() . '_' . uniqid() . '.' . $this->screenshot->getClientOriginalExtension();
                $screenshotPath = $this->screenshot->storeAs('doctor-documents', $filename, 'public');
            } catch (\Exception $e) {
                $this->addError('screenshot', 'Failed to upload screenshot: ' . $e->getMessage());
                return;
            }
        }

        $payment = UserGatewayPayment::create([
            'user_id' => Auth::id(),
            'payment_gateway_id' => $this->selectedGatewayId,
            'transaction_id' => $this->transactionId,
            'screenshot_path' => $screenshotPath,
        ]);

        // Also create a Transaction record for super admin to see
        $doctor = Auth::user();
        $gateway = PaymentGateway::find($this->selectedGatewayId);
        
        // Generate unique transaction ID
        $uniqueTransactionId = 'TXN-' . strtoupper(uniqid());
        
        $invoice = null;
        $invoiceAmount = 0.00;
        
        if ($this->selectedInvoiceId) {
            $invoice = Invoice::find($this->selectedInvoiceId);
            if ($invoice && $invoice->user_id == Auth::id()) {
                $invoiceAmount = $invoice->total;
            } else {
                $invoice = null;
            }
        }

        $transaction = Transaction::create([
            'transaction_id' => $uniqueTransactionId,
            'user_id' => Auth::id(),
            'invoice_id' => $invoice?->id,
            'type' => 'payment',
            'status' => $invoice ? 'completed' : 'pending',
            'amount' => $invoiceAmount,
            'currency' => 'USD',
            'payment_method' => 'gateway_payment',
            'payment_gateway' => $gateway?->name,
            'gateway_transaction_id' => $this->transactionId,
            'description' => $invoice 
                ? "Payment for invoice {$invoice->invoice_number} via {$gateway?->name}"
                : "Payment submitted via {$gateway?->name}",
            'metadata' => [
                'user_gateway_payment_id' => $payment->id,
                'screenshot_path' => $screenshotPath,
            ],
        ]);

        // If invoice is linked, update invoice status to paid
        if ($invoice) {
            $invoice->update(['status' => 'paid']);
            
            // Send notifications
            try {
                \App\Notifications\InvoiceNotification::sendPaidNotifications($invoice);
            } catch (\Exception $e) {
                \Log::error('Failed to send invoice paid notifications: ' . $e->getMessage());
            }
        }

        // Notify current doctor, organization (if exists), and super admin
        $message = $invoice 
            ? "Payment for invoice {$invoice->invoice_number} submitted via {$gateway?->name} (Txn: {$this->transactionId})."
            : "Payment submitted via {$gateway?->name} (Txn: {$this->transactionId}).";

        $data = [
            'title' => $invoice ? 'Payment Submitted for Invoice' : 'Payment Submitted',
            'message' => $message,
            'type' => 'success',
            'url' => route('doctor.invoice-payments'),
            'payment_id' => $payment->id,
            'doctor_id' => $doctor->id,
            'gateway_name' => $gateway?->name,
            'transaction_id' => $this->transactionId,
            'invoice_id' => $invoice?->id,
            'invoice_number' => $invoice?->invoice_number,
        ];

        try {
            $doctor->notify(new UserPaymentNotification($data));
            
            // If doctor has organization, notify organization
            if ($doctor->org_id) {
                $organization = User::find($doctor->org_id);
                if ($organization) {
                    $organization->notify(new UserPaymentNotification($data));
                }
            }
            
            $admin = User::where('user_type', \App\Enums\UserType::SUPER_ADMIN)->first();
            if ($admin) {
                $admin->notify(new UserPaymentNotification($data));
            }
        } catch (\Exception $e) {
            // swallow notification errors to not block submission
        }

        $this->closeAddModal();
        session()->flash('message', 'Payment submitted successfully!');
    }

    public function getActiveGateways()
    {
        return PaymentGateway::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function getPayments()
    {
        return UserGatewayPayment::query()
            ->with('paymentGateway')
            ->where('user_id', Auth::id())
            ->when($this->search, function ($q) {
                $q->where('transaction_id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('paymentGateway', function ($gq) {
                      $gq->where('name', 'like', '%' . $this->search . '%');
                  });
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }

    public function getTransactionForPayment($paymentId)
    {
        return Transaction::where('metadata->user_gateway_payment_id', $paymentId)
            ->with('invoice')
            ->first();
    }

    public function render()
    {
        $gateways = $this->getActiveGateways();
        $payments = $this->getPayments();

        $selectedGateway = null;
        if ($this->selectedGatewayId) {
            $selectedGateway = $gateways->firstWhere('id', (int) $this->selectedGatewayId);
        }

        return view('livewire.doctor.invoice-payments-component', [
            'gateways' => $gateways,
            'payments' => $payments,
            'selectedGateway' => $selectedGateway,
            'pendingInvoices' => $this->getPendingInvoices(),
        ]);
    }
}


