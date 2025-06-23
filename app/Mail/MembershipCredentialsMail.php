<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class MembershipCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

   public $email, $password, $name, $membershipNumber, $phone, $pdfPath;

public function __construct($email, $password, $name, $membershipNumber, $phone, $pdfPath)
{
    $this->email = $email;
    $this->password = $password;
    $this->name = $name;
    $this->membershipNumber = $membershipNumber;
    $this->phone = $phone;
    $this->pdfPath = $pdfPath;
}

public function build()
{
    return $this->subject('Your Membership Login Credentials')
                ->view('emails.membership_credentials')
                ->with([
                    'email' => $this->email,
                    'password' => $this->password,
                ])
                ->attach($this->pdfPath, [
                    'as' => 'KESA_Membership_Card.pdf',
                    'mime' => 'application/pdf',
                ]);
}
}

