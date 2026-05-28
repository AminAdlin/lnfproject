<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Claim;

class ClaimNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $claim;
    public $details;
    public $scenario;
    

    public function __construct(Claim $claim, $details, $scenario)
    {
        $this->claim = $claim;
        $this->details = $details;
        $this->scenario = $scenario; 
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Someone Claimed Your Found Item - UTM FoundIt',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.claim-notification',
        );
    }
}