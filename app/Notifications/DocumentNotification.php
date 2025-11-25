<?php

namespace App\Notifications;

use App\Models\DoctorDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $document;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct(DoctorDocument $document, string $type = 'uploaded')
    {
        $this->document = $document;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database', 'mail'];
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
            'document_id' => $this->document->id,
            'document_type' => $this->document->documentType->name ?? 'Unknown',
            'original_filename' => $this->document->original_filename,
            'upload_date' => $this->document->upload_date?->format('Y-m-d'),
            'is_verified' => $this->document->is_verified,
            'url' => $this->getUrl(),
        ]);
    }

    /**
     * Get the notification title based on type
     */
    protected function getTitle(): string
    {
        return match ($this->type) {
            'uploaded' => 'Document Uploaded',
            'verified' => 'Document Verified',
            'rejected' => 'Document Rejected',
            'updated' => 'Document Updated',
            default => 'Document Notification',
        };
    }

    /**
     * Get the notification message based on type
     */
    protected function getMessage(): string
    {
        return match ($this->type) {
            'uploaded' => "You have uploaded a new document: {$this->document->original_filename}",
            'verified' => "Your document '{$this->document->original_filename}' has been verified",
            'rejected' => "Your document '{$this->document->original_filename}' has been rejected",
            'updated' => "Your document '{$this->document->original_filename}' has been updated",
            default => "Document '{$this->document->original_filename}' notification",
        };
    }

    /**
     * Get the URL for the notification
     */
    protected function getUrl(): string
    {
        return route('doctor.documents');
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->getTitle())
            ->line($this->getMessage())
            ->when($this->document->documentType, function ($mail) {
                return $mail->line('Document Type: ' . ($this->document->documentType->name ?? 'Unknown'));
            })
            ->when($this->document->upload_date, function ($mail) {
                return $mail->line('Upload Date: ' . $this->document->upload_date->format('F d, Y'));
            })
            ->when($this->type === 'verified', function ($mail) {
                return $mail->line('Your document has been verified and is now active.');
            })
            ->when($this->type === 'rejected', function ($mail) {
                return $mail->line('Please review the document requirements and upload a corrected version.');
            })
            ->line('View documents: ' . $this->getUrl());
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return $this->toDatabase($notifiable)->data;
    }
}
