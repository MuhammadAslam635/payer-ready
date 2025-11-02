<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserPaymentNotification extends Notification
{
    use Queueable;

    protected $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->data['title'] ?? 'New Payment Submitted')
            ->line($this->data['message'] ?? 'A new payment has been submitted.')
            ->action('View', url($this->data['url'] ?? '/'))
            ->line('Thank you.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->data['title'] ?? 'Notification',
            'message' => $this->data['message'] ?? '',
            'type' => $this->data['type'] ?? 'info',
            'url' => $this->data['url'] ?? '#',
            'payment_id' => $this->data['payment_id'] ?? null,
            'doctor_id' => $this->data['doctor_id'] ?? null,
            'gateway_name' => $this->data['gateway_name'] ?? null,
            'transaction_id' => $this->data['transaction_id'] ?? null,
        ];
    }
}


