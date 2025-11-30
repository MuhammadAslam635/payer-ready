<?php

namespace App\Livewire\Organization;

use App\Models\PaymentGateway;
use App\Models\UserGatewayPayment;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\DoctorCredential;
use App\Services\OrganizationCredentialingFeeService;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UserPaymentNotification;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Title('Doctor Invoice Payments')]
#[Layout('layouts.dashboard')]
class DoctorInvoicePaymentsComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $invoiceSearch = '';
    public $perPage = 10;
    public $showAddModal = false;
    public $showInvoiceModal = false;
    public $selectedInvoice = null;
    public $selectedInvoiceId = '';
    public $selectedGatewayId = '';
    public $selectedDoctorId = '';
    public $transactionId = '';
    public $screenshot = null;

    protected $queryString = ['search'];

    protected $listeners = [
        'open-invoice-modal' => 'openInvoiceModal',
    ];

    protected function rules(): array
    {
        return [
            'selectedGatewayId' => 'required|exists:payment_gateways,id',
            'selectedDoctorId' => 'required|exists:users,id',
            'selectedInvoiceId' => 'nullable|exists:invoices,id',
            'transactionId' => 'required|string|max:255',
            'screenshot' => 'nullable|image|max:4096',
        ];
    }

    public function openAddModal($invoiceId = null): void
    {
        if ($invoiceId) {
            $adminId = Auth::id();
            $doctorIds = User::query()
                ->where('org_id', $adminId)
                ->where('user_type', \App\Enums\UserType::DOCTOR)
                ->pluck('id');

            $invoice = Invoice::where('id', $invoiceId)
                ->whereIn('user_id', $doctorIds)
                ->first();
            if ($invoice) {
                $this->selectedDoctorId = $invoice->user_id;
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
        $adminId = Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $adminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        $this->selectedInvoice = Invoice::with(['invoiceItems', 'user'])
            ->where('id', $invoiceId)
            ->whereIn('user_id', $doctorIds)
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
            $adminId = Auth::id();
            $doctorIds = User::query()
                ->where('org_id', $adminId)
                ->where('user_type', \App\Enums\UserType::DOCTOR)
                ->pluck('id');

            $invoice = Invoice::where('id', $invoiceId)
                ->whereIn('user_id', $doctorIds)
                ->first();
            if ($invoice) {
                $this->selectedDoctorId = $invoice->user_id;
                $this->selectedInvoiceId = $invoice->id;
                $this->openAddModal($invoiceId);
                return;
            }
        } elseif ($this->selectedInvoice && $this->selectedInvoice->user) {
            $this->selectedDoctorId = $this->selectedInvoice->user_id;
            $this->selectedInvoiceId = $this->selectedInvoice->id;
            $this->openAddModal($this->selectedInvoice->id);
            return;
        }
        
        $this->openAddModal();
    }

    private function resetForm(): void
    {
        $this->selectedGatewayId = '';
        $this->selectedDoctorId = '';
        $this->selectedInvoiceId = '';
        $this->transactionId = '';
        $this->screenshot = null;
        $this->resetValidation();
    }

    public function getPendingInvoices()
    {
        $adminId = Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $adminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id')
            ->toArray();
        
        // Include organization admin itself
        $allUserIds = array_merge([$adminId], $doctorIds);

        $query = Invoice::with(['invoiceItems'])
            ->whereIn('user_id', $allUserIds)
            ->where('status', 'pending');

        // If doctor is selected, filter by that doctor
        if ($this->selectedDoctorId) {
            if (!in_array((int)$this->selectedDoctorId, $allUserIds, true)) {
                return collect();
            }
            $query->where('user_id', $this->selectedDoctorId);
        }

        return $query->when($this->invoiceSearch, function ($q) {
                $q->where('invoice_number', 'like', '%' . $this->invoiceSearch . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Generate invoices for pending credentialing enrollments
     */
    public function generateCredentialingInvoices()
    {
        try {
            $organization = Auth::user();
            $feeService = new OrganizationCredentialingFeeService();
            
            $result = $feeService->createInvoicesForPendingEnrollments($organization);
            
            if ($result['created'] > 0) {
                session()->flash('success', "Successfully created {$result['created']} invoice(s) for pending enrollments.");
            } else {
                session()->flash('info', 'No new invoices to create. All pending enrollments already have invoices.');
            }
            
            $this->dispatch('invoices-generated');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to generate invoices: ' . $e->getMessage());
            \Log::error('Failed to generate credentialing invoices: ' . $e->getMessage());
        }
    }

    public function getPayments()
    {
        $adminId = Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $adminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        return UserGatewayPayment::query()
            ->with(['paymentGateway','user'])
            ->whereIn('user_id', $doctorIds)
            ->when($this->search, function ($q) {
                $q->where('transaction_id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('paymentGateway', function ($gq) {
                      $gq->where('name', 'like', '%' . $this->search . '%');
                  });
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }

    public function getActiveGateways()
    {
        return PaymentGateway::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function getDoctors()
    {
        $doctors = User::query()
            ->where('org_id', Auth::id())
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->orderBy('name')
            ->get(['id','name','email']);
        
        // Add organization itself at the beginning
        $organization = Auth::user();
        $orgData = (object)[
            'id' => $organization->id,
            'name' => $organization->business_name ?? $organization->name,
            'email' => $organization->email,
        ];
        
        return collect([$orgData])->concat($doctors);
    }

    public function save(): void
    {
        $this->validate();

        $allowedDoctorIds = $this->getDoctors()->pluck('id')->all();
        if (!in_array((int)$this->selectedDoctorId, $allowedDoctorIds, true)) {
            $this->addError('selectedDoctorId', 'Invalid doctor selection.');
            return;
        }

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
            'user_id' => (int)$this->selectedDoctorId,
            'payment_gateway_id' => (int)$this->selectedGatewayId,
            'transaction_id' => $this->transactionId,
            'screenshot_path' => $screenshotPath,
        ]);

        $doctor = User::find((int)$this->selectedDoctorId);
        $gateway = PaymentGateway::find((int)$this->selectedGatewayId);
        
        // Also create a Transaction record for super admin to see
        $uniqueTransactionId = 'TXN-' . strtoupper(uniqid());
        
        $invoice = null;
        $invoiceAmount = 0.00;
        
        if ($this->selectedInvoiceId) {
            $invoice = Invoice::find($this->selectedInvoiceId);
            if ($invoice && $invoice->user_id == (int)$this->selectedDoctorId) {
                $invoiceAmount = $invoice->total;
            } else {
                $invoice = null;
            }
        }

        $transaction = Transaction::create([
            'transaction_id' => $uniqueTransactionId,
            'user_id' => (int)$this->selectedDoctorId,
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
        
        $message = $invoice 
            ? "Payment for invoice {$invoice->invoice_number} submitted via {$gateway?->name} (Txn: {$this->transactionId})."
            : "Payment submitted via {$gateway?->name} (Txn: {$this->transactionId}).";

        $data = [
            'title' => $invoice ? 'Payment Submitted for Invoice' : 'Payment Submitted',
            'message' => $message,
            'type' => 'success',
            'url' => route('organization-admin.doctor_invoice_payments'),
            'payment_id' => $payment->id,
            'doctor_id' => $doctor?->id,
            'gateway_name' => $gateway?->name,
            'transaction_id' => $this->transactionId,
            'invoice_id' => $invoice?->id,
            'invoice_number' => $invoice?->invoice_number,
        ];

        try {
            if ($doctor) {
                $doctor->notify(new UserPaymentNotification($data));
            }
            
            // Notify organization admin
            $orgAdmin = Auth::user();
            if ($orgAdmin) {
                $orgAdmin->notify(new UserPaymentNotification($data));
            }
            
            $admin = User::where('user_type', \App\Enums\UserType::SUPER_ADMIN)->first();
            if ($admin) {
                $admin->notify(new UserPaymentNotification($data));
            }
        } catch (\Exception $e) {
            // ignore notification failures
        }

        $this->closeAddModal();
    }

    public function render()
    {
        return view('livewire.organization.doctor-invoice-payments-component', [
            'payments' => $this->getPayments(),
            'gateways' => $this->getActiveGateways(),
            'doctors' => $this->getDoctors(),
            'selectedGateway' => $this->selectedGatewayId ? $this->getActiveGateways()->firstWhere('id', (int)$this->selectedGatewayId) : null,
            'pendingInvoices' => $this->getPendingInvoices(),
        ]);
    }
}


