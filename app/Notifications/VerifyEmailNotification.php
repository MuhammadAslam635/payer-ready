<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        try {
            \Log::info('VerifyEmailNotification: Creating verification URL for user: ' . $notifiable->email);
            
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addDays(7),
                ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
            );

            \Log::info('VerifyEmailNotification: Verification URL created successfully');
            \Log::info('VerifyEmailNotification: Verification URL: ' . $verificationUrl);

            $mailMessage = (new MailMessage)
                        ->subject('Verify Your Email Address')
                        ->markdown('mail.verify-email', [
                            'user' => $notifiable,
                            'verificationUrl' => $verificationUrl,
                        ]);

            \Log::info('VerifyEmailNotification: MailMessage object created successfully');
            \Log::info('VerifyEmailNotification: Sending email to: ' . $notifiable->email);

            return $mailMessage;
        } catch (\Exception $e) {
            \Log::error('VerifyEmailNotification: Error in toMail method');
            \Log::error('VerifyEmailNotification Error: ' . $e->getMessage());
            \Log::error('VerifyEmailNotification Trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

