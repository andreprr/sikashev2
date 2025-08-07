<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification; // Correct import for Notification
use Illuminate\Notifications\Messages\MailMessage; // Correct import for MailMessage
use Illuminate\Support\Facades\URL;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Crypt;

class NotifEmail extends Notification
{
    use Queueable;

    protected $subject;
    protected $messageLines;
    protected $actionDetails;

    /**
     * Create a new notification instance.
     */
    public function __construct($subject, $messageLines = [], $actionDetails = [])
    {
        $this->subject = $subject;
        $this->messageLines = $messageLines;
        $this->actionDetails = $actionDetails;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)->subject($this->subject);

        // Add the dynamic lines to the message
        foreach ($this->messageLines as $line) {
            $mailMessage->line($line);
        }

        // Add action button if provided
        if (!empty($this->actionDetails)) {
            $mailMessage->action(
                $this->actionDetails['text'],
                $this->actionDetails['url']
            );
        }

        $mailMessage->line('Thank you for using our application!');
        
        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'subject' => $this->subject,
            'messageLines' => $this->messageLines,
            'actionDetails' => $this->actionDetails,
        ];
    }
}