<?php

namespace App\Livewire\Organization;

use App\Models\PaymentGateway;
use App\Models\UserGatewayPayment;
use App\Models\User;
use App\Models\Transaction;
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
    public $perPage = 10;
    public $showAddModal = false;
    public $selectedGatewayId = '';
    public $selectedDoctorId = '';
    public $transactionId = '';
    public $screenshot = null;

    protected $queryString = ['search'];

    protected function rules(): array
    {
        return [
            'selectedGatewayId' => 'required|exists:payment_gateways,id',
            'selectedDoctorId' => 'required|exists:users,id',
            'transactionId' => 'required|string|max:255',
            'screenshot' => 'nullable|image|max:4096',
        ];
    }

    public function openAddModal(): void
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function closeAddModal(): void
    {
        $this->showAddModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->selectedGatewayId = '';
        $this->selectedDoctorId = '';
        $this->transactionId = '';
        $this->screenshot = null;
        $this->resetValidation();
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
        return User::query()
            ->where('org_id', Auth::id())
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->orderBy('name')
            ->get(['id','name','email']);
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
            $filename = 'gateway_payment_' . time() . '_' . uniqid() . '.' . $this->screenshot->getClientOriginalExtension();
            $screenshotPath = $this->screenshot->storeAs('doctor-documents', $filename, 'public');
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
        
        Transaction::create([
            'transaction_id' => $uniqueTransactionId,
            'user_id' => (int)$this->selectedDoctorId,
            'invoice_id' => null, // Will be linked when invoice is available
            'type' => 'payment',
            'status' => 'pending',
            'amount' => 0.00, // Can be updated later when invoice is linked
            'currency' => 'USD',
            'payment_method' => 'gateway_payment',
            'payment_gateway' => $gateway?->name,
            'gateway_transaction_id' => $this->transactionId,
            'description' => "Payment submitted via {$gateway?->name}",
            'metadata' => [
                'user_gateway_payment_id' => $payment->id,
                'screenshot_path' => $screenshotPath,
            ],
        ]);
        
        $message = "Payment submitted via {$gateway?->name} (Txn: {$this->transactionId}).";

        $data = [
            'title' => 'Payment Submitted',
            'message' => $message,
            'type' => 'success',
            'url' => route('organization-admin.doctor_invoice_payments'),
            'payment_id' => $payment->id,
            'doctor_id' => $doctor?->id,
            'gateway_name' => $gateway?->name,
            'transaction_id' => $this->transactionId,
        ];

        try {
            if ($doctor) {
                $doctor->notify(new UserPaymentNotification($data));
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
        ]);
    }
}


