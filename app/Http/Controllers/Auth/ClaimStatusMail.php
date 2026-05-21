<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Claim;

class ClaimStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $claim;
    public $statusType;

    public function __construct(Claim $claim, string $statusType)
    {
        $this->claim      = $claim;
        $this->statusType = $statusType;
    }

    public function envelope(): Envelope
    {
        $subject = $this->statusType === 'approved'
            ? '✅ Your Claim Has Been Approved - UTM FoundIt'
            : '❌ Your Claim Has Been Rejected - UTM FoundIt';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.claim-status');
    }
}