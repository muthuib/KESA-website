<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class MailService
{
    public function sendWelcomeEmail($userEmail, $userName)
    {
        $mail = new PHPMailer(true); // Passing true enables exceptions
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use Mailtrap or your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'benmuthui98@gmail.com'; // Mailtrap username
            $mail->Password = 'wzlp bfwf scgl yide'; // Mailtrap password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('no-reply@example.com', 'KESA Website');
            $mail->addAddress($userEmail, $userName); // Add recipient's email and name

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to KESA Website';
            $mail->Body    = '<h1>Welcome, ' . $userName . '!</h1><p>Thank you for signing up at KESA Website.</p>';
            $mail->AltBody = 'Welcome, ' . $userName . '. Thank you for signing up at KESA Website.';

            //Send email
            $mail->send();
            Log::info("Welcome email sent to: " . $userEmail);
        } catch (Exception $e) {
            Log::error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}
