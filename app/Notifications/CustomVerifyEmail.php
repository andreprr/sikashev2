<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Notifications\Notification; // Correct import for Notification
use Illuminate\Notifications\Messages\MailMessage; // Correct import for MailMessage
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Crypt;

class CustomVerifyEmail extends Notification
{
    protected $user;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $token = Crypt::encryptString($this->user->email);
        $verificationUrl = url('/custom/verify-email?token=' . urlencode($token));

        return (new MailMessage)
                    ->subject('Verify Your Email Address')
                    ->line('Please click the button below to verify your email address.')
                    ->action('Verify Email Address', $verificationUrl)
                    ->line('If you did not create an account, no further action is required.');
    }
}
