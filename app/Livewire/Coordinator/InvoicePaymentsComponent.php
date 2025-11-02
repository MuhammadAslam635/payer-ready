<?php

namespace App\Livewire\Coordinator;

use App\Models\User;
use App\Models\UserGatewayPayment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Invoice Payments')]
#[Layout('layouts.dashboard')]
class InvoicePaymentsComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $queryString = ['search'];

    public function getPayments()
    {
        $orgAdminId = Auth::user()->org_id ?: Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $orgAdminId)
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

    public function render()
    {
        return view('livewire.coordinator.invoice-payments-component', [
            'payments' => $this->getPayments(),
        ]);
    }
}


