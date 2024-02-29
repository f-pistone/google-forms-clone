<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);
$email_user = $_POST['email_user'];

try {

  $mail->isSMTP();
  $mail->isHTML(true);
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPAuth = true;
  $mail->Username = "";
  $mail->Password = "";
  $mail->SMTPSecure = "ssl";
  $mail->Port = 465;

  $body = "";
  $body .= "<html>";
  $body .= "  <body>";
  $body .= "    <h1>Your password has been changed</h1>";
  $body .= "    <p>";
  $body .= "      You have successfully changed your password. If it wasn't you, well, this is a problem...";
  $body .= "    </p>";
  $body .= "  </body>";
  $body .= "</html>";

  $mail->setFrom("", "Google Forms Clone");
  $mail->addAddress($email_user);

  $mail->Subject = "Your password has been changed";
  $mail->Body = $body;

  $mail->send();

  echo 1;
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
