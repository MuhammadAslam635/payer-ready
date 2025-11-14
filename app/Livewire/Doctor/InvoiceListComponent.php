<?php

namespace App\Livewire\Doctor;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('My Invoices')]
#[Layout('layouts.dashboard')]
class InvoiceListComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $showInvoiceModal = false;
    public $selectedInvoice = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
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

    public function getInvoices()
    {
        return Invoice::with(['invoiceItems', 'transactions'])
            ->where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('invoice_number', 'like', '%' . $this->search . '%')
                      ->orWhere('notes', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function openInvoiceModal($invoiceId): void
    {
        $this->selectedInvoice = Invoice::with(['invoiceItems', 'user', 'transactions.userGatewayPayment'])
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

    public function openPayoutFromInvoice()
    {
        $this->closeInvoiceModal();
        return redirect()->route('doctor.invoice-payments');
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
        return view('livewire.doctor.invoice-list-component', [
            'invoices' => $this->getInvoices(),
        ]);
    }
}

