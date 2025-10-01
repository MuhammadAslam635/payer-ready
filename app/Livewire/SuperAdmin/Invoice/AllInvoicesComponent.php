<?php

namespace App\Livewire\SuperAdmin\Invoice;

use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout as AttributesLayout;
use App\Traits\HasToast;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

#[AttributesLayout('layouts.dashboard')]
class AllInvoicesComponent extends Component
{
    use WithPagination, HasToast;

    public $search = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $paymentMethodFilter = '';
    public $paymentGatewayFilter = '';
    public $userFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 15;

    // Available filter options
    public $statusOptions = [
        'pending' => 'Pending',
        'completed' => 'Completed',
        'failed' => 'Failed',
        'cancelled' => 'Cancelled'
    ];

    public $typeOptions = [
        'payment' => 'Payment',
        'refund' => 'Refund',
        'credit' => 'Credit',
        'debit' => 'Debit'
    ];

    public $paymentMethodOptions = [
        'credit_card' => 'Credit Card',
        'bank_transfer' => 'Bank Transfer',
        'paypal' => 'PayPal',
        'stripe' => 'Stripe',
        'cash' => 'Cash',
        'check' => 'Check'
    ];

    public $paymentGatewayOptions = [
        'stripe' => 'Stripe',
        'paypal' => 'PayPal',
        'square' => 'Square',
        'authorize_net' => 'Authorize.Net'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'paymentMethodFilter' => ['except' => ''],
        'paymentGatewayFilter' => ['except' => ''],
        'userFilter' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
    ];

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

    public function updatingPaymentMethodFilter()
    {
        $this->resetPage();
    }

    public function updatingPaymentGatewayFilter()
    {
        $this->resetPage();
    }

    public function updatingUserFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function getTransactions()
    {
        $query = Transaction::with(['user', 'organization'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('transaction_id', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('gateway_transaction_id', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($userQuery) {
                          $userQuery->where('name', 'like', '%' . $this->search . '%')
                                   ->orWhere('email', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->paymentMethodFilter, function ($query) {
                $query->where('payment_method', $this->paymentMethodFilter);
            })
            ->when($this->paymentGatewayFilter, function ($query) {
                $query->where('payment_gateway', $this->paymentGatewayFilter);
            })
            ->when($this->userFilter, function ($query) {
                $query->where('user_id', $this->userFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->orderBy('created_at', 'desc');

        return $query->paginate($this->perPage);
    }

    public function updateStatus($transactionId, $status)
    {
        try {
            $transaction = Transaction::findOrFail($transactionId);
            $transaction->update([
                'status' => $status,
                'processed_at' => $status === 'completed' ? now() : null
            ]);

            $this->toastSuccess('Transaction status updated successfully!');
        } catch (\Exception $e) {
            $this->toastError('Error updating transaction status: ' . $e->getMessage());
        }
    }

    public function downloadTransaction($transactionId)
    {
        try {
            $transaction = Transaction::with(['user', 'organization'])->findOrFail($transactionId);
            
            $content = $this->generateTransactionReport($transaction);
            
            return Response::streamDownload(function () use ($content) {
                echo $content;
            }, 'transaction_' . $transaction->transaction_id . '.txt', [
                'Content-Type' => 'text/plain',
            ]);
        } catch (\Exception $e) {
            $this->toastError('Error downloading transaction: ' . $e->getMessage());
        }
    }

    public function downloadAllTransactions()
    {
        try {
            $transactions = $this->getTransactions();
            
            $content = $this->generateBulkTransactionReport($transactions->items());
            
            return Response::streamDownload(function () use ($content) {
                echo $content;
            }, 'all_transactions_' . now()->format('Y-m-d_H-i-s') . '.csv', [
                'Content-Type' => 'text/csv',
            ]);
        } catch (\Exception $e) {
            $this->toastError('Error downloading transactions: ' . $e->getMessage());
        }
    }

    private function generateTransactionReport($transaction)
    {
        $report = "TRANSACTION REPORT\n";
        $report .= "==================\n\n";
        $report .= "Transaction ID: " . $transaction->transaction_id . "\n";
        $report .= "User: " . ($transaction->user ? $transaction->user->name : 'N/A') . "\n";
        $report .= "Email: " . ($transaction->user ? $transaction->user->email : 'N/A') . "\n";
        $report .= "Organization: " . ($transaction->organization ? $transaction->organization->business_name : 'N/A') . "\n";
        $report .= "Type: " . ucfirst($transaction->type) . "\n";
        $report .= "Status: " . ucfirst($transaction->status) . "\n";
        $report .= "Amount: $" . number_format($transaction->amount, 2) . " " . $transaction->currency . "\n";
        $report .= "Payment Method: " . ($transaction->payment_method ? ucfirst(str_replace('_', ' ', $transaction->payment_method)) : 'N/A') . "\n";
        $report .= "Payment Gateway: " . ($transaction->payment_gateway ? ucfirst($transaction->payment_gateway) : 'N/A') . "\n";
        $report .= "Gateway Transaction ID: " . ($transaction->gateway_transaction_id ?: 'N/A') . "\n";
        $report .= "Description: " . ($transaction->description ?: 'N/A') . "\n";
        $report .= "Created At: " . $transaction->created_at->format('Y-m-d H:i:s') . "\n";
        $report .= "Processed At: " . ($transaction->processed_at ? $transaction->processed_at->format('Y-m-d H:i:s') : 'N/A') . "\n";
        
        if ($transaction->metadata) {
            $report .= "\nMetadata:\n";
            foreach ($transaction->metadata as $key => $value) {
                $report .= "  " . ucfirst(str_replace('_', ' ', $key)) . ": " . $value . "\n";
            }
        }
        
        return $report;
    }

    private function generateBulkTransactionReport($transactions)
    {
        $csv = "Transaction ID,User Name,User Email,Organization,Type,Status,Amount,Currency,Payment Method,Payment Gateway,Gateway Transaction ID,Description,Created At,Processed At\n";
        
        foreach ($transactions as $transaction) {
            $csv .= '"' . $transaction->transaction_id . '",';
            $csv .= '"' . ($transaction->user ? $transaction->user->name : '') . '",';
            $csv .= '"' . ($transaction->user ? $transaction->user->email : '') . '",';
            $csv .= '"' . ($transaction->organization ? $transaction->organization->business_name : '') . '",';
            $csv .= '"' . ucfirst($transaction->type) . '",';
            $csv .= '"' . ucfirst($transaction->status) . '",';
            $csv .= '"' . $transaction->amount . '",';
            $csv .= '"' . $transaction->currency . '",';
            $csv .= '"' . ($transaction->payment_method ? ucfirst(str_replace('_', ' ', $transaction->payment_method)) : '') . '",';
            $csv .= '"' . ($transaction->payment_gateway ? ucfirst($transaction->payment_gateway) : '') . '",';
            $csv .= '"' . ($transaction->gateway_transaction_id ?: '') . '",';
            $csv .= '"' . ($transaction->description ?: '') . '",';
            $csv .= '"' . $transaction->created_at->format('Y-m-d H:i:s') . '",';
            $csv .= '"' . ($transaction->processed_at ? $transaction->processed_at->format('Y-m-d H:i:s') : '') . '"' . "\n";
        }
        
        return $csv;
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'statusFilter',
            'typeFilter',
            'paymentMethodFilter',
            'paymentGatewayFilter',
            'userFilter',
            'dateFrom',
            'dateTo'
        ]);
        $this->resetPage();
    }

    public function getUsers()
    {
        return User::select('id', 'name', 'email')
            ->orderBy('name')
            ->get();
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'completed' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'failed' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getTypeColor($type)
    {
        return match($type) {
            'payment' => 'bg-blue-100 text-blue-800',
            'refund' => 'bg-orange-100 text-orange-800',
            'credit' => 'bg-green-100 text-green-800',
            'debit' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getTransactionStats()
    {
        $totalTransactions = Transaction::count();
        $totalAmount = Transaction::where('status', 'completed')->sum('amount');
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $failedTransactions = Transaction::where('status', 'failed')->count();
        
        return [
            'total_transactions' => $totalTransactions,
            'total_amount' => $totalAmount,
            'pending_transactions' => $pendingTransactions,
            'failed_transactions' => $failedTransactions,
        ];
    }

    public function render()
    {
        return view('livewire.super-admin.invoice.all-invoices-component', [
            'transactions' => $this->getTransactions(),
            'users' => $this->getUsers(),
            'stats' => $this->getTransactionStats(),
            'statusOptions' => $this->statusOptions,
            'typeOptions' => $this->typeOptions,
            'paymentMethodOptions' => $this->paymentMethodOptions,
            'paymentGatewayOptions' => $this->paymentGatewayOptions,
        ]);
    }
}
