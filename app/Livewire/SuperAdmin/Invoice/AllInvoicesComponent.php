<?php

namespace App\Livewire\SuperAdmin\Invoice;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Transaction;
use App\Models\UserGatewayPayment;
use App\Notifications\InvoiceNotification;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout as AttributesLayout;
use App\Traits\HasToast;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[AttributesLayout('layouts.dashboard')]
class AllInvoicesComponent extends Component
{
    use WithPagination, HasToast;

    public $search = '';
    public $statusFilter = '';
    public $userFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 15;
    public $showLinkPaymentModal = false;
    public $selectedInvoiceForLink = null;
    public $selectedTransactionId = '';

    // Available filter options
    public $statusOptions = [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'overdue' => 'Overdue',
        'cancelled' => 'Cancelled'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
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

    public function getInvoices()
    {
        $query = Invoice::with(['user', 'invoiceItems'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('invoice_number', 'like', '%' . $this->search . '%')
                      ->orWhere('notes', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($userQuery) {
                          $userQuery->where('name', 'like', '%' . $this->search . '%')
                                   ->orWhere('email', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
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

    public function updateStatus($invoiceId, $status)
    {
        try {
            $invoice = Invoice::findOrFail($invoiceId);
            $oldStatus = $invoice->status;
            $invoice->update([
                'status' => $status,
            ]);

            // Send notification if status changed to paid
            if ($status === 'paid' && $oldStatus !== 'paid') {
                $this->sendStatusChangeNotification($invoice);
            }

            $this->toastSuccess('Invoice status updated successfully!');
        } catch (\Exception $e) {
            $this->toastError('Error updating invoice status: ' . $e->getMessage());
        }
    }

    public function openLinkPaymentModal($invoiceId)
    {
        $this->selectedInvoiceForLink = Invoice::with(['user', 'transactions'])->findOrFail($invoiceId);
        $this->selectedTransactionId = '';
        $this->showLinkPaymentModal = true;
    }

    public function closeLinkPaymentModal()
    {
        $this->showLinkPaymentModal = false;
        $this->selectedInvoiceForLink = null;
        $this->selectedTransactionId = '';
    }

    public function linkPayment()
    {
        $this->validate([
            'selectedTransactionId' => 'required|exists:transactions,id',
        ]);

        try {
            DB::beginTransaction();

            $transaction = Transaction::findOrFail($this->selectedTransactionId);
            $invoice = $this->selectedInvoiceForLink;

            // Check if transaction already linked to another invoice
            if ($transaction->invoice_id && $transaction->invoice_id != $invoice->id) {
                $this->toastError('This payment is already linked to another invoice.');
                DB::rollBack();
                return;
            }

            // Link transaction to invoice
            $transaction->update([
                'invoice_id' => $invoice->id,
                'amount' => $invoice->total,
                'status' => 'completed',
            ]);

            // Update invoice status to paid
            if ($invoice->status !== 'paid') {
                $invoice->update(['status' => 'paid']);
                
                // Send notifications
                $this->sendStatusChangeNotification($invoice);
            }

            DB::commit();

            $this->toastSuccess('Payment linked successfully! Invoice marked as paid.');
            $this->closeLinkPaymentModal();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->toastError('Error linking payment: ' . $e->getMessage());
        }
    }

    protected function sendStatusChangeNotification(Invoice $invoice)
    {
        try {
            // Notify the invoice owner (doctor)
            if ($invoice->user) {
                $invoice->user->notify(new InvoiceNotification($invoice, 'paid'));
            }

            // If doctor has organization, notify organization
            if ($invoice->user && $invoice->user->org_id) {
                $organization = User::find($invoice->user->org_id);
                if ($organization) {
                    $organization->notify(new InvoiceNotification($invoice, 'paid'));
                }
            }

            // Notify all super admins
            $superAdmins = User::where('user_type', \App\Enums\UserType::SUPER_ADMIN)->get();
            foreach ($superAdmins as $admin) {
                $admin->notify(new InvoiceNotification($invoice, 'paid'));
            }
        } catch (\Exception $e) {
            // Log error but don't fail the transaction
            \Log::error('Failed to send invoice status change notification: ' . $e->getMessage());
        }
    }

    public function getAvailablePayments()
    {
        if (!$this->selectedInvoiceForLink) {
            return collect();
        }

        $userId = $this->selectedInvoiceForLink->user_id;

        return Transaction::where('user_id', $userId)
            ->where('type', 'payment')
            ->where(function($q) {
                $q->whereNull('invoice_id')
                  ->orWhere('invoice_id', $this->selectedInvoiceForLink->id);
            })
            ->where('status', 'pending')
            ->with('userGatewayPayment')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function downloadInvoice($invoiceId)
    {
        try {
            $invoice = Invoice::with(['user', 'invoiceItems'])->findOrFail($invoiceId);
            
            $content = $this->generateInvoiceReport($invoice);
            
            return Response::streamDownload(function () use ($content) {
                echo $content;
            }, 'invoice_' . $invoice->invoice_number . '.txt', [
                'Content-Type' => 'text/plain',
            ]);
        } catch (\Exception $e) {
            $this->toastError('Error downloading invoice: ' . $e->getMessage());
        }
    }

    public function downloadAllInvoices()
    {
        try {
            $invoices = $this->getInvoices();
            
            $content = $this->generateBulkInvoiceReport($invoices->items());
            
            return Response::streamDownload(function () use ($content) {
                echo $content;
            }, 'all_invoices_' . now()->format('Y-m-d_H-i-s') . '.csv', [
                'Content-Type' => 'text/csv',
            ]);
        } catch (\Exception $e) {
            $this->toastError('Error downloading invoices: ' . $e->getMessage());
        }
    }

    private function generateInvoiceReport($invoice)
    {
        $report = "INVOICE REPORT\n";
        $report .= "==============\n\n";
        $report .= "Invoice Number: " . $invoice->invoice_number . "\n";
        $report .= "User: " . ($invoice->user ? $invoice->user->name : 'N/A') . "\n";
        $report .= "Email: " . ($invoice->user ? $invoice->user->email : 'N/A') . "\n";
        $report .= "Status: " . ucfirst($invoice->status) . "\n";
        $report .= "Subtotal: $" . number_format($invoice->subtotal, 2) . "\n";
        $report .= "Discount: $" . number_format($invoice->discount, 2) . "\n";
        $report .= "Tax: $" . number_format($invoice->tax, 2) . "\n";
        $report .= "Total: $" . number_format($invoice->total, 2) . "\n";
        $report .= "Due Date: " . ($invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A') . "\n";
        $report .= "Notes: " . ($invoice->notes ?: 'N/A') . "\n";
        $report .= "Created At: " . $invoice->created_at->format('Y-m-d H:i:s') . "\n";
        
        if ($invoice->invoiceItems->count() > 0) {
            $report .= "\nInvoice Items:\n";
            foreach ($invoice->invoiceItems as $item) {
                $report .= "  - " . $item->description . " (Qty: " . $item->quantity . ", Price: $" . number_format($item->unit_price, 2) . ", Amount: $" . number_format($item->amount, 2) . ")\n";
            }
        }
        
        return $report;
    }

    private function generateBulkInvoiceReport($invoices)
    {
        $csv = "Invoice Number,User Name,User Email,Status,Subtotal,Discount,Tax,Total,Due Date,Created At\n";
        
        foreach ($invoices as $invoice) {
            $csv .= '"' . $invoice->invoice_number . '",';
            $csv .= '"' . ($invoice->user ? $invoice->user->name : '') . '",';
            $csv .= '"' . ($invoice->user ? $invoice->user->email : '') . '",';
            $csv .= '"' . ucfirst($invoice->status) . '",';
            $csv .= '"' . $invoice->subtotal . '",';
            $csv .= '"' . $invoice->discount . '",';
            $csv .= '"' . $invoice->tax . '",';
            $csv .= '"' . $invoice->total . '",';
            $csv .= '"' . ($invoice->due_date ? $invoice->due_date->format('Y-m-d') : '') . '",';
            $csv .= '"' . $invoice->created_at->format('Y-m-d H:i:s') . '"' . "\n";
        }
        
        return $csv;
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'statusFilter',
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
            'paid' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'overdue' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getInvoiceStats()
    {
        $totalInvoices = Invoice::count();
        $totalAmount = Invoice::where('status', 'paid')->sum('total');
        $pendingInvoices = Invoice::where('status', 'pending')->count();
        $overdueInvoices = Invoice::where('status', 'overdue')->count();
        
        return [
            'total_invoices' => $totalInvoices,
            'total_amount' => $totalAmount,
            'pending_invoices' => $pendingInvoices,
            'overdue_invoices' => $overdueInvoices,
        ];
    }

    public function render()
    {
        return view('livewire.super-admin.invoice.all-invoices-component', [
            'invoices' => $this->getInvoices(),
            'users' => $this->getUsers(),
            'stats' => $this->getInvoiceStats(),
            'statusOptions' => $this->statusOptions,
        ]);
    }
}
