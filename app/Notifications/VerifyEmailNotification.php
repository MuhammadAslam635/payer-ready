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
            \Log::info('VerifyEmailNotification: APP_URL from config: ' . config('app.url'));
            
            // Ensure URL uses the correct domain from config
            // Set the URL root before generating signed route to use production domain
            $originalUrl = config('app.url');
            if ($originalUrl && $originalUrl !== 'http://localhost') {
                // Temporarily set APP_URL if it's not set correctly
                if (str_contains($originalUrl, 'localhost')) {
                    \Log::warning('VerifyEmailNotification: APP_URL contains localhost, using request host');
                    $appUrl = request()->getSchemeAndHttpHost();
                    if ($appUrl && $appUrl !== 'http://localhost:8000') {
                        config(['app.url' => $appUrl]);
                    }
                }
            }
            
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addDays(7),
                ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
            );
            
            // Restore original config if changed
            if (isset($appUrl)) {
                config(['app.url' => $originalUrl]);
            }
            
            // Final check: replace localhost if still present
            if (str_contains($verificationUrl, 'localhost')) {
                $currentHost = request()->getSchemeAndHttpHost();
                if ($currentHost && !str_contains($currentHost, 'localhost')) {
                    $verificationUrl = str_replace(request()->root(), $currentHost, $verificationUrl);
                }
            }

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

