<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\DoctorCertificate;
use App\Models\User;

class CertificateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $certificate;
    protected $doctor;
    protected $action;

    /**
     * Create a new notification instance.
     */
    public function __construct(DoctorCertificate $certificate, User $doctor, string $action = 'added')
    {
        $this->certificate = $certificate;
        $this->doctor = $doctor;
        $this->action = $action;
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
        $actionText = $this->action === 'added' ? 'added a new certificate' : 'requested a new certificate';
        
        return (new MailMessage)
            ->subject('New Certificate ' . ucfirst($this->action))
            ->line("Dr. {$this->doctor->name} has {$actionText}.")
            ->line("Certificate Type: {$this->certificate->certificateType->name}")
            ->line("Certificate Number: {$this->certificate->certificate_number}")
            ->line('View certificate: ' . url('/admin/certificates/' . $this->certificate->id))
            ->line('Please review this certificate application.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $actionText = $this->action === 'added' ? 'added a new certificate' : 'requested a new certificate';
        
        return [
            'title' => 'New Certificate ' . ucfirst($this->action),
            'message' => "Dr. {$this->doctor->name} has {$actionText}",
            'type' => $this->action === 'added' ? 'success' : 'info',
            'certificate_id' => $this->certificate->id,
            'doctor_id' => $this->doctor->id,
            'action' => $this->action,
            'certificate_type' => $this->certificate->certificateType->name ?? 'Unknown',
            'certificate_number' => $this->certificate->certificate_number,
            'url' => '/admin/certificates/' . $this->certificate->id,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}
