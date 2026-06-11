<?php

namespace App\Mail;

use App\Models\Dispute;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FakeReceiptWarningMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dispute;

    public function __construct(Dispute $dispute)
    {
        $this->dispute = $dispute;
    }

    public function build()
    {
        return $this->subject('Warning: Fake Receipt Report')
                    ->view('auth.emails.fake_receipt_warning');
    }
}