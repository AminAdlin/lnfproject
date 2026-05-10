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

    public function __construct(Claim $claim)
    {
        $this->claim = $claim;
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