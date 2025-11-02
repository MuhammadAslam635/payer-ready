<?php

namespace App\Livewire\Doctor;

use App\Models\PaymentGateway;
use App\Models\UserGatewayPayment;
use App\Models\User;
use App\Notifications\UserPaymentNotification;
use Illuminate\Support\Facades\Auth;
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

    public $selectedGatewayId = '';
    public $transactionId = '';
    public $screenshot = null;

    public $search = '';
    public $perPage = 10;

    protected function rules(): array
    {
        return [
            'selectedGatewayId' => 'required|exists:payment_gateways,id',
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
        $this->transactionId = '';
        $this->screenshot = null;
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        $screenshotPath = null;
        if ($this->screenshot) {
            $filename = 'gateway_payment_' . time() . '_' . uniqid() . '.' . $this->screenshot->getClientOriginalExtension();
            $screenshotPath = $this->screenshot->storeAs('doctor-documents', $filename, 'public');
        }

        $payment = UserGatewayPayment::create([
            'user_id' => Auth::id(),
            'payment_gateway_id' => $this->selectedGatewayId,
            'transaction_id' => $this->transactionId,
            'screenshot_path' => $screenshotPath,
        ]);

        // Notify current doctor and first super admin
        $doctor = Auth::user();
        $gateway = PaymentGateway::find($this->selectedGatewayId);
        $message = "Payment submitted via {$gateway?->name} (Txn: {$this->transactionId}).";

        $data = [
            'title' => 'Payment Submitted',
            'message' => $message,
            'type' => 'success',
            'url' => route('doctor.invoice-payments'),
            'payment_id' => $payment->id,
            'doctor_id' => $doctor->id,
            'gateway_name' => $gateway?->name,
            'transaction_id' => $this->transactionId,
        ];

        try {
            $doctor->notify(new UserPaymentNotification($data));
            $admin = User::where('user_type', \App\Enums\UserType::SUPER_ADMIN)->first();
            if ($admin) {
                $admin->notify(new UserPaymentNotification($data));
            }
        } catch (\Exception $e) {
            // swallow notification errors to not block submission
        }

        $this->closeAddModal();
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
        ]);
    }
}


