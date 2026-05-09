<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $logo;

    public function __construct()
    {
        // embed image
        $this->logo = asset('images/UTMFOUNDIT.png');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email - UTMFoundIt',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify',
            with: [
                'logo' => $this->logo,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
