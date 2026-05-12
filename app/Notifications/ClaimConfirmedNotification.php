<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimConfirmedNotification extends Notification
{
    private $itemName;
    private $claimantName;

    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($itemName, $claimantName)
    {
        $this->itemName = $itemName;
        $this->claimantName = $claimantName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Item Claim Confirmed')
            ->view('emails.claim-confirmed', [
            'finderName' => $notifiable->name,
            'itemName' => $this->itemName,
            'claimantName' => $this->claimantName,
            ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your item "' . $this->itemName . '" has been claimed by ' . $this->claimantName,
        ];
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
