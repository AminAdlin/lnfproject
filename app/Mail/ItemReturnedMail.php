<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ItemReturnedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $item;
    public $claim;

    public function __construct($item, $claim)
    {
        $this->item = $item;
        $this->claim = $claim;
    }

    public function build()
    {
        return $this->subject('UTMFoundIt - Has your item arrived?')
                    ->view('emails.item_returned');
    }
}