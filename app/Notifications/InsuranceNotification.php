<?php

namespace App\Notifications;

use App\Enums\UserType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InsuranceNotification extends Notification
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = new MailMessage;

        $dashboardUrl = $this->getDashboardUrl($notifiable);

        if (($this->data['type'] ?? null) === 'payer_enrollment_request') {
            $mailMessage
                ->subject('New Payer Enrollment Request')
                ->line('A new payer enrollment request has been submitted.')
                ->line('Provider: ' . $this->data['provider_name'])
                ->line('Payer: ' . $this->data['payer_name'])
                ->line('State: ' . $this->data['state_name'])
                ->line('Request Type: ' . $this->data['request_type'])
                ->line('Default Amount: $' . number_format($this->data['default_amount'], 2))
                ->line('View all requests: ' . $dashboardUrl)
                ->line('Please review and process this request.');
        } elseif (($this->data['type'] ?? null) === 'payer_enrollment_confirmation') {
            $mailMessage
                ->subject('Payer Enrollment Request Submitted')
                ->line('Your payer enrollment request has been successfully submitted.')
                ->line('Provider: ' . $this->data['provider_name'])
                ->line('Payer: ' . $this->data['payer_name'])
                ->line('State: ' . $this->data['state_name'])
                ->line('Request Type: ' . $this->data['request_type'])
                ->line('Default Amount: $' . number_format($this->data['default_amount'], 2))
                ->line('View status: ' . $dashboardUrl)
                ->line('We will notify you once your request has been processed.');
        }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->data['type'] ?? 'insurance_notification',
            'title' => $this->getTitle(),
            'message' => $this->getMessage(),
            'data' => $this->data,
        ];
    }

    /**
     * Get the notification title based on type
     */
    private function getTitle(): string
    {
        switch ($this->data['type'] ?? '') {
            case 'payer_enrollment_request':
                return 'New Payer Enrollment Request';
            case 'payer_enrollment_confirmation':
                return 'Payer Enrollment Request Submitted';
            default:
                return 'Insurance Notification';
        }
    }

    /**
     * Get the notification message based on type
     */
    private function getMessage(): string
    {
        switch ($this->data['type'] ?? '') {
            case 'payer_enrollment_request':
                return "New enrollment request from {$this->data['provider_name']} for {$this->data['payer_name']} in {$this->data['state_name']}";
            case 'payer_enrollment_confirmation':
                return "Your enrollment request for {$this->data['payer_name']} in {$this->data['state_name']} has been submitted";
            default:
                return 'You have a new insurance notification';
        }
    }

    /**
     * Resolve dashboard URL based on user type.
     */
    protected function getDashboardUrl($notifiable): string
    {
        return match ($notifiable->user_type ?? null) {
            UserType::SUPER_ADMIN => route('super-admin.view_all_credentials'),
            UserType::ORGANIZATION_ADMIN => route('organization-admin.doctor_applications'),
            UserType::DOCTOR => route('doctor.applications'),
            default => url('/'),
        };
    }
}
