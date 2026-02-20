<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public static function sendWelcome($toEmail, $name)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'aungkyawthethimself@gmail.com';
            $mail->Password   = 'your_app_password';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('aungkyawthethimself@gmail.com', 'Umbra');
            $mail->addAddress($toEmail, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Umbra';
            $mail->Body    = "
                <h2>Welcome to Umbra, {$name}!</h2>
                <p>We're glad to have you here.</p>
                <p>Start writing your thoughts today.</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log($mail->ErrorInfo);
        }
    }
}