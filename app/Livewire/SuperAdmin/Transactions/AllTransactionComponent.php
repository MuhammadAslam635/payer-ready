<?php

namespace App\Livewire\SuperAdmin\Transactions;

use App\Enums\UserType;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class AllTransactionComponent extends Component
{
    use WithPagination;

    // Search and filter properties
    public $search = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $userFilter = '';
    public $paymentMethodFilter = '';

    // Sorting properties
    public $sortBy = 'id';
    public $sortDirection = 'desc';

    // Modal properties
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $selectedTransaction = null;

    // Edit form properties
    public $editStatus = '';
    public $editType = '';
    public $editAmount = '';
    public $editPaymentMethod = '';
    public $editDescription = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'userFilter' => ['except' => ''],
        'paymentMethodFilter' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected $rules = [
        'editStatus' => 'required|in:pending,processing,completed,failed,cancelled,refunded',
        'editType' => 'required|in:payment,refund,adjustment,fee',
        'editAmount' => 'required|numeric|min:0',
        'editPaymentMethod' => 'nullable|string|max:50',
        'editDescription' => 'nullable|string|max:500',
    ];

    // Reset pagination when search/filter changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingUserFilter()
    {
        $this->resetPage();
    }

    public function updatingPaymentMethodFilter()
    {
        $this->resetPage();
    }

    // Sorting functionality
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Clear all filters
    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->typeFilter = '';
        $this->userFilter = '';
        $this->paymentMethodFilter = '';
        $this->resetPage();
    }

    // Edit transaction functionality
    public function editTransaction($transactionId)
    {
        $this->selectedTransaction = Transaction::findOrFail($transactionId);
        $this->editStatus = $this->selectedTransaction->status;
        $this->editType = $this->selectedTransaction->type;
        $this->editAmount = $this->selectedTransaction->amount;
        $this->editPaymentMethod = $this->selectedTransaction->payment_method;
        $this->editDescription = $this->selectedTransaction->description;
        $this->showEditModal = true;
    }

    // Update transaction
    public function updateTransaction()
    {
        $this->validate();

        $this->selectedTransaction->update([
            'status' => $this->editStatus,
            'type' => $this->editType,
            'amount' => $this->editAmount,
            'payment_method' => $this->editPaymentMethod,
            'description' => $this->editDescription,
        ]);

        session()->flash('message', 'Transaction updated successfully.');
        $this->closeModal();
    }

    // Confirm delete
    public function confirmDelete($transactionId)
    {
        $this->selectedTransaction = Transaction::findOrFail($transactionId);
        $this->showDeleteModal = true;
    }

    // Delete transaction
    public function deleteTransaction()
    {
        $this->selectedTransaction->delete();
        session()->flash('message', 'Transaction deleted successfully.');
        $this->closeModal();
    }

    // Close modal and reset validation
    public function closeModal()
    {
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->selectedTransaction = null;
        $this->resetValidation();
        $this->reset(['editStatus', 'editType', 'editAmount', 'editPaymentMethod', 'editDescription']);
    }

    public function render()
    {
        $transactions = Transaction::with(['user', 'invoice'])
            ->when($this->search, function ($query) {
                $query->where('transaction_id', 'like', '%' . $this->search . '%')
                      ->orWhere('gateway_transaction_id', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->userFilter, function ($query) {
                $query->where('user_id', $this->userFilter);
            })
            ->when($this->paymentMethodFilter, function ($query) {
                $query->where('payment_method', $this->paymentMethodFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        $users = User::whereIn('user_type', [UserType::DOCTOR, UserType::ORGANIZATION_ADMIN])->get();
        $transactionStatuses = ['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'];
        $transactionTypes = ['payment', 'refund', 'adjustment', 'fee'];
        $paymentMethods = Transaction::distinct()->pluck('payment_method')->filter()->values();

        return view('livewire.super-admin.transactions.all-transaction-component', [
            'transactions' => $transactions,
            'users' => $users,
            'transactionStatuses' => $transactionStatuses,
            'transactionTypes' => $transactionTypes,
            'paymentMethods' => $paymentMethods,
        ]);
    }
}
