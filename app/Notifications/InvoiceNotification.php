<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class InvoiceNotification extends Notification
{
    use Queueable;

    protected $invoice;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct(Invoice $invoice, string $type = 'created')
    {
        $this->invoice = $invoice;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'type' => $this->type,
            'title' => $this->getTitle(),
            'message' => $this->getMessage(),
            'invoice_id' => $this->invoice->id,
            'invoice_number' => $this->invoice->invoice_number,
            'amount' => $this->invoice->total,
            'due_date' => $this->invoice->due_date?->format('Y-m-d'),
            'status' => $this->invoice->status,
            'url' => $this->getUrl($notifiable),
            'icon' => 'shopping-cart', // Cart icon for invoice notifications
        ]);
    }

    /**
     * Get the notification title based on type
     */
    protected function getTitle(): string
    {
        return match ($this->type) {
            'created' => 'New Invoice Created',
            'updated' => 'Invoice Updated',
            'paid' => 'Invoice Paid',
            'overdue' => 'Invoice Overdue',
            default => 'Invoice Notification',
        };
    }

    /**
     * Get the notification message based on type
     */
    protected function getMessage(): string
    {
        $invoiceNumber = $this->invoice->invoice_number;
        $amount = '$' . number_format($this->invoice->total, 2);
        
        return match ($this->type) {
            'created' => "A new invoice ({$invoiceNumber}) for {$amount} has been created. Please review and make payment.",
            'updated' => "Invoice {$invoiceNumber} has been updated.",
            'paid' => "Invoice {$invoiceNumber} has been marked as paid.",
            'overdue' => "Invoice {$invoiceNumber} is now overdue. Please make payment immediately.",
            default => "Invoice {$invoiceNumber} notification",
        };
    }

    /**
     * Get the URL for the notification based on user type
     */
    protected function getUrl($notifiable): string
    {
        // Route to invoice list page - can be customized based on user type
        if ($notifiable->user_type === \App\Enums\UserType::DOCTOR) {
            return route('doctor.invoices');
        } elseif ($notifiable->user_type === \App\Enums\UserType::ORGANIZATION_ADMIN) {
            return route('organization-admin.invoices');
        }
        
        return route('super-admin.all_invoices');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return $this->toDatabase($notifiable)->data;
    }

    /**
     * Send paid notifications to all relevant users
     */
    public static function sendPaidNotifications(Invoice $invoice)
    {
        // Notify the invoice owner (doctor)
        if ($invoice->user) {
            $invoice->user->notify(new self($invoice, 'paid'));
        }

        // If doctor has organization, notify organization
        if ($invoice->user && $invoice->user->org_id) {
            $organization = \App\Models\User::find($invoice->user->org_id);
            if ($organization) {
                $organization->notify(new self($invoice, 'paid'));
            }
        }

        // Notify all super admins
        $superAdmins = \App\Models\User::where('user_type', \App\Enums\UserType::SUPER_ADMIN)->get();
        foreach ($superAdmins as $admin) {
            $admin->notify(new self($invoice, 'paid'));
        }
    }
}

