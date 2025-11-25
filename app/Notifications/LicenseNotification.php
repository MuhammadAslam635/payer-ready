<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LicenseNotification extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->data['title'] ?? 'New License Notification')
            ->line($this->data['message'] ?? 'A new license notification has been created.')
            ->line("License Type: " . ($this->data['license_type'] ?? 'Unknown'))
            ->line("License Number: " . ($this->data['license_number'] ?? 'Unknown'))
            ->line('View license: ' . ($this->data['url'] ?? url('/admin/licenses')))
            ->line('Please review this license application.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->data['title'] ?? 'Notification',
            'message' => $this->data['message'] ?? '',
            'type' => $this->data['type'] ?? 'info',
            'url' => $this->data['url'] ?? '#',
            'license_id' => $this->data['license_id'] ?? null,
            'doctor_id' => $this->data['doctor_id'] ?? null,
            'action' => $this->data['action'] ?? null,
            'license_type' => $this->data['license_type'] ?? null,
            'license_number' => $this->data['license_number'] ?? null,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): array
    {
        return $this->data;
    }
}