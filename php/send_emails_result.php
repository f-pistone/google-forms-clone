<?php
include_once("../database/conn.php");
require_once('../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$id_result = (int)$_POST['id_result'];
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
  $mail->Host = $_ENV['MAIL_HOST'];
  $mail->SMTPAuth = true;
  $mail->Username = $_ENV['MAIL_USERNAME'];
  $mail->Password = $_ENV['MAIL_PASSWORD'];
  $mail->SMTPSecure = $_ENV['MAIL_SMTPSECURE'];
  $mail->Port = $_ENV['MAIL_PORT'];

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

  $mail->setFrom($_ENV['MAIL_USERNAME'], "Google Forms Clone");
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
  $mail->Host = $_ENV['MAIL_HOST'];
  $mail->SMTPAuth = true;
  $mail->Username = $_ENV['MAIL_USERNAME'];
  $mail->Password = $_ENV['MAIL_PASSWORD'];
  $mail->SMTPSecure = $_ENV['MAIL_SMTPSECURE'];
  $mail->Port = $_ENV['MAIL_PORT'];

  $body = "";
  $body .= "<html>";
  $body .= "  <body>";
  $body .= "    <h1>Thanks to completed the form $title_form</h1>";
  $body .= "    <p>";
  $body .= "      Hi, we inform you that your result has been sent.";
  $body .= "    </p>";
  $body .= "    <p>";
  $body .= "      You can download the pdf file with the result <a href='http://localhost/google-forms-clone/php/download_result_pdf.php?id_result=$id_result'>here</a>";
  $body .= "    </p>";
  $body .= "  </body>";
  $body .= "</html>";

  $mail->setFrom($_ENV['MAIL_USERNAME'], "Google Forms Clone");
  $mail->addAddress($email_user_result);

  $mail->Subject = "Thanks to completed the form $title_form";
  $mail->Body = $body;

  $mail->send();

  echo 1;
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
