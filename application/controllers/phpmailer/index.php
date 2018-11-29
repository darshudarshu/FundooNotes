<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

//Load Composer's autoloader
require "/var/www/html/codeigniter/application/controllers/phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "/var/www/html/codeigniter/application/controllers/phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php";
require 'vendor/autoload.php';
class Mailing
{
    public function sendMail($email, $body, $sub)
    {
        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true; // Enable SMTP authentication
            $mail->Username   = 'darshangangadhar@gmail.com'; // SMTP username
            $mail->Password   = 'darshu@4150'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587; // TCP port to connect to
            //Recipients
            $mail->setFrom('darshangangadhar@gmail.com', 'Mailer');
            $mail->addAddress($email, 'darshu'); // Add a recipient
            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $sub;
            $mail->Body    = $body;

            $mail->send();
            // echo "Message has been sent";
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: ", $mail->ErrorInfo;
        }

    }
}
