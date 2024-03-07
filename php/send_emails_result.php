<?php
include_once("../database/conn.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);
$email_user_result = $_POST['email_user_result'];
$id_form = (int)$_POST['id_form'];
$email_user = null;

$sqlGetUserAndForm = "SELECT 
                      users.first_name_user, 
                      users.last_name_user, 
                      users.email_user, 
                      forms.title_form
                    FROM 
                      forms 
                        INNER JOIN 
                      users ON users.id_user = forms.id_user 
                    WHERE 
                      forms.id_form = $id_form";
$queryGetUserAndForm = mysqli_query($conn, $sqlGetUserAndForm) or die("Error: get user's email");
$rowGetUserAndForm = mysqli_fetch_assoc($queryGetUserAndForm);
$first_name_user = $rowGetUserAndForm['first_name_user'];
$last_name_user = $rowGetUserAndForm['last_name_user'];
$email_user = $rowGetUserAndForm['email_user'];
$title_form = $rowGetUserAndForm['title_form'];

//Email to the owner of the form
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
  $body .= "    <h1>New result</h1>";
  $body .= "    <p>";
  $body .= "      Hi $first_name_user $last_name_user. A new person completed the form <strong>$title_form</strong>";
  $body .= "    </p>";
  $body .= "    <p>";
  $body .= "      To see the result click <a href='http://localhost/google-forms-clone/edit_form.php?id_form=$id_form' target='_blank'>here</a>";
  $body .= "    </p>";
  $body .= "  </body>";
  $body .= "</html>";

  $mail->setFrom("", "Google Forms Clone");
  $mail->addAddress($email_user);

  $mail->Subject = "New result";
  $mail->Body = $body;

  $mail->send();

  echo 1;
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

//Email to the user who completed the form
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
  $body .= "    <h1>Thanks to completed the form $title_form</h1>";
  $body .= "    <p>";
  $body .= "      Hi, we inform you that your result has been sent.";
  $body .= "    </p>";
  $body .= "  </body>";
  $body .= "</html>";

  $mail->setFrom("", "Google Forms Clone");
  $mail->addAddress($email_user_result);

  $mail->Subject = "Thanks to completed the form $title_form";
  $mail->Body = $body;

  $mail->send();

  echo 1;
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
