<?php
require_once("../dotenv.php");
require_once('../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$email_user = $_POST['email_user'];

try {

  $mail->isSMTP();
  $mail->isHTML(true);
  $mail->Host = $_ENV['MAIL_HOST'];
  $mail->SMTPAuth = true;
  $mail->Username = $_ENV['MAIL_USERNAME'];
  $mail->Password = $_ENV['MAIL_PASSWORD'];
  $mail->SMTPSecure = $_ENV['MAIL_SMTPSECURE'];
  $mail->Port = $_ENV['MAIL_PORT'];

  $body = "";
  $body .= "<html>";
  $body .= "  <body>";
  $body .= "    <h1>Your password has been changed</h1>";
  $body .= "    <p>";
  $body .= "      You have successfully changed your password. If it wasn't you, contact the support.";
  $body .= "    </p>";
  $body .= "  </body>";
  $body .= "</html>";

  $mail->setFrom($_ENV['MAIL_USERNAME'], "Google Forms Clone");
  $mail->addAddress($email_user);

  $mail->Subject = "Your password has been changed";
  $mail->Body = $body;

  $mail->send();

  echo 1;
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
