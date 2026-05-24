<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $claim;
    public $address;

    public function __construct($claim, $address)
    {
    $this->claim = $claim;
    $this->address = $address;
    }
    public function build()
    {
        $email = $this->subject('UTM FoundIt - Claimant Payment Receipt Uploaded!')
                      ->view('payment_receipt');


        $receiptName = $this->claim->payment_receipt; 

        if ($receiptName) {
            
            $path1 = storage_path('app/public/' . $receiptName);
            $path2 = storage_path('app/' . $receiptName);
            $path3 = public_path('storage/' . $receiptName); 

            if (file_exists($path1)) {
                return $email->attach($path1);
            } elseif (file_exists($path2)) {
                return $email->attach($path2);
            } elseif (file_exists($path3)) {
                return $email->attach($path3);
            } else {
                \Log::error("Fail resit wujud dalam DB tapi tak jumpa dalam server. Path dicari: " . $path1);
            }
        } else {
            \Log::warning("Column payment_receipt kosong untuk Claim ID: " . $this->claim->id);
        }

        return $email;
    }
}