<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $event;
    public $qrCode;

    /**
     * Create a new message instance.
     *
     * @param $registration
     * @param $event
     * @param $qrCode
     */
    public function __construct($registration, $event, $qrCode)
    {
        $this->registration = $registration;
        $this->event = $event;
        $this->qrCode = $qrCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Event Registration Receipt')
            ->view('emails.registration-receipt')
            ->with([
                'registration' => $this->registration,
                'event' => $this->event,
                'qrCode' => $this->qrCode,
            ]);
    }
}
