<?php

namespace App\Livewire\Organization;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Doctor Invoices')]
#[Layout('layouts.dashboard')]
class InvoiceListComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $doctorFilter = '';
    public $perPage = 10;
    public $showInvoiceModal = false;
    public $selectedInvoice = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'doctorFilter' => ['except' => ''],
    ];

    protected $listeners = [
        'open-invoice-modal' => 'openInvoiceModal',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingDoctorFilter()
    {
        $this->resetPage();
    }

    public function getInvoices()
    {
        $adminId = Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $adminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        return Invoice::with(['invoiceItems', 'user', 'transactions.userGatewayPayment'])
            ->whereIn('user_id', $doctorIds)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('invoice_number', 'like', '%' . $this->search . '%')
                      ->orWhere('notes', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($userQuery) {
                          $userQuery->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->doctorFilter, function ($query) {
                $query->where('user_id', $this->doctorFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function getDoctors()
    {
        return User::query()
            ->where('org_id', Auth::id())
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
    }

    public function openInvoiceModal($invoiceId): void
    {
        $adminId = Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $adminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        $this->selectedInvoice = Invoice::with(['invoiceItems', 'user', 'transactions.userGatewayPayment'])
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

    public function openPayoutFromInvoice()
    {
        if ($this->selectedInvoice && $this->selectedInvoice->user) {
            $this->closeInvoiceModal();
            return redirect()->route('organization-admin.doctor_invoice_payments');
        }
        return null;
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'paid' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'overdue' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function render()
    {
        return view('livewire.organization.invoice-list-component', [
            'invoices' => $this->getInvoices(),
            'doctors' => $this->getDoctors(),
        ]);
    }
}

