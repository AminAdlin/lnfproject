<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ItemNotReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dispute;

    /**
     * Create a new message instance.
     */
    public function __construct($dispute)
    {
        $this->dispute = $dispute;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Item Not Received - Dispute Update')
            ->view('emails.item-not-received')
            ->with([
                'dispute' => $this->dispute
            ]);
    }
}