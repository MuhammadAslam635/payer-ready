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
            
            // Get APP_URL from config - this should be set in .env file
            $appUrl = config('app.url');
            \Log::info('VerifyEmailNotification: APP_URL from config: ' . $appUrl);
            
            // Ensure APP_URL is set and includes port if needed
            if (!$appUrl || str_contains($appUrl, 'localhost')) {
                // Try to get from request if available (for production)
                if (request()->hasHeader('Host')) {
                    $host = request()->getHost();
                    $scheme = request()->getScheme();
                    $port = request()->getPort();
                    
                    if ($host && !str_contains($host, 'localhost')) {
                        $appUrl = $scheme . '://' . $host;
                        if ($port && $port != 80 && $port != 443) {
                            $appUrl .= ':' . $port;
                        }
                        \Log::info('VerifyEmailNotification: Using request host: ' . $appUrl);
                        // Temporarily set config to use correct URL for route generation
                        config(['app.url' => $appUrl]);
                    } elseif ($host && str_contains($host, 'localhost') && $port) {
                        // For localhost, include port if available
                        $appUrl = $scheme . '://' . $host . ':' . $port;
                        \Log::info('VerifyEmailNotification: Using localhost with port: ' . $appUrl);
                        config(['app.url' => $appUrl]);
                    }
                }
            }
            
            // Force URL generator to use APP_URL
            if ($appUrl) {
                URL::forceRootUrl($appUrl);
            }
            
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addDays(7),
                ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
            );
            
            // Reset URL root if we changed it
            URL::forceRootUrl(null);
            
            // Final check: ensure no localhost in the URL
            if (str_contains($verificationUrl, 'localhost')) {
                $finalUrl = config('app.url');
                if ($finalUrl && !str_contains($finalUrl, 'localhost')) {
                    // Replace localhost with production domain
                    $verificationUrl = str_replace('http://localhost:8000', $finalUrl, $verificationUrl);
                    $verificationUrl = str_replace('https://localhost:8000', $finalUrl, $verificationUrl);
                    $verificationUrl = str_replace('http://localhost', $finalUrl, $verificationUrl);
                    $verificationUrl = str_replace('https://localhost', $finalUrl, $verificationUrl);
                    \Log::warning('VerifyEmailNotification: Replaced localhost in URL');
                }
            }

            \Log::info('VerifyEmailNotification: Verification URL created successfully');
            \Log::info('VerifyEmailNotification: Final Verification URL: ' . $verificationUrl);

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

