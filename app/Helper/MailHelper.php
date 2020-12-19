<?php
namespace App\Helper;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Support\Facades\Log;

// Load Composer's autoloader
// require 'vendor/autoload.php';


class MailHelper
{
    private $mail;
    private $webMail;
    private $webMailPass;
    private $webMailName;
    private $debug = false;

    public function __construct()
    {

        $this->webMail = "web.sp.nhan@gmail.com";
        $this->webMailPass = "ndnhan187539115";
        $this->webMailName = "Web Mail";
    }

    public function sendEmailTest($val)
    {
        Log::debug($val);
    }
    public function sendEmail(
        $recipientMail = "",
        $recipientName = "",
        $subject = "",
        $message = ""
    ) {
        $this->mail = new PHPMailer(true);
        try {
            try {
                //Server settings
                // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $this->mail->SMTPDebug = ($this->debug) ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF;
                $this->mail->isSMTP(); // Send using SMTP
                $this->mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                $this->mail->SMTPAuth = true; // Enable SMTP authentication
                $this->mail->Username = $this->webMail; // SMTP username
                $this->mail->Password = $this->webMailPass; // SMTP password
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $this->mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                $this->mail->CharSet = 'UTF-8';

                //Recipients
                $this->mail->setFrom($this->webMail, $this->webMailName);
                $this->mail->clearAllRecipients();
            } catch (Exception $e) {
                $style = '"color: #ff0000;"';
                // echo "<h1 style={$style}><Strong>Message could not be sent. Mailer Error: {$this->mail->ErrorInfo} </Strong></h1>";
            }

            $this->mail->addAddress($recipientMail, $recipientName); // Add a recipient
            // Content
            $this->mail->isHTML(true); // Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->AltBody = $message;

            if (true) {
                // if ($this->mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            $style = '"color: #ff0000;"';
            // echo "<h1 style={$style}><Strong>Message could not be sent. Mailer Error: {$this->mail->ErrorInfo} </Strong></h1>";
            return false;
        }
        // return ($data . $data);
        return true;
    }

}
