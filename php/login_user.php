<?php
include_once("../database/conn.php");

$email_user = addslashes($_POST['email_user']);
$password_user = hash("sha256", $_POST['password_user']);

$sqlLogin = "SELECT id_user FROM users WHERE email_user = '$email_user' AND password_user = '$password_user'";
$queryLogin = mysqli_query($conn, $sqlLogin) or die("Error: user login");
$user_exist = (int)mysqli_num_rows($queryLogin);

if ($user_exist == 1) {
  $row = mysqli_fetch_assoc($queryLogin);
  session_start();
  $_SESSION['id_user'] = (int)$row['id_user'];
  echo $_SESSION['id_user'];
} else {
  echo -1;
}

return;
