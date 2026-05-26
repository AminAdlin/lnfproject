<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $item;
    public $claimant;

    public function __construct($item, $claimant)
    {
        $this->item = $item;
        $this->claimant = $claimant;
    }

    public function build()
    {
        return $this->subject('🔔 Action Required: Set Appointment for ' . $this->item->title)
                    ->view('emails.appointment_reminder');
    }
}
