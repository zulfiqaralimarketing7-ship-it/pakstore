<?php
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOrderMail($to, $name, $orderId, $total)
{

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'YOUR_GMAIL@gmail.com';
        $mail->Password = 'YOUR_GMAIL_APP_PASSWORD';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('YOUR_GMAIL@gmail.com', 'PakStore');
        $mail->addAddress($to, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Order Confirmed - PakStore';

        $mail->Body = "
    <h2>Order Confirmed</h2>
    Hello $name,<br>
    Your order <b>#$orderId</b> confirmed.<br>
    <b>Total:</b> Rs $total<br>
    Delivery in 2–3 days.<br><br>
    Thanks for shopping at PakStore ❤️
    ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>