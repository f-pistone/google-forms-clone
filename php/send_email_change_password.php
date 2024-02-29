<?php
include_once("../database/conn.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);
$email_user = $_POST['email_user'];

$sqlGetUser = "SELECT id_user, uniqid FROM users WHERE email_user = '$email_user'";
$queryGetUser = mysqli_query($conn, $sqlGetUser) or die("Error: get user");
$user_exists = (int)mysqli_num_rows($queryGetUser);

if ($user_exists == 1) {
  $rowGetUser = mysqli_fetch_assoc($queryGetUser);
  $id_user = (int)$rowGetUser['id_user'];
  $uniqid = $rowGetUser['uniqid'];
  $email_user_html = htmlspecialchars($email_user, ENT_QUOTES);
} else {
  echo -1;
  return;
}

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
  $body .= "    <h1>Change password</h1>";
  $body .= "    <p>";
  $body .= "      To change your password click ";
  $body .= "      <a href='localhost/google-forms-clone/new_password.php?e=$email_user_html&u=$id_user&uid=$uniqid'>here</a>";
  $body .= "    </p>";
  $body .= "  </body>";
  $body .= "</html>";

  $mail->setFrom("", "Google Forms Clone");
  $mail->addAddress($email_user);

  $mail->Subject = "Change password";
  $mail->Body = $body;

  $mail->send();

  echo 1;
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
