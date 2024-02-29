<?php
include_once("../database/conn.php");

$id_user = (int)$_POST['id_user'];
$email_user = addslashes($_POST['email_user']);
$uniqid = addslashes($_POST['uniqid']);
$new_password_user = hash("sha256", $_POST['new_password_user']);

$sqlCheckUser = "SELECT id_user FROM users WHERE id_user = $id_user AND email_user = '$email_user' AND uniqid = '$uniqid'";
$queryCheckUser = mysqli_query($conn, $sqlCheckUser) or die("Error: check user");
$user_check = (int)mysqli_num_rows($queryCheckUser);

if ($user_check == 0) {
  echo -1;
  return;
}

$sqlChangePasswordUser = "UPDATE 
                            users 
                          SET 
                            password_user = '$new_password_user'
                          WHERE 
                            id_user = $id_user";
$queryChangePasswordUser = mysqli_query($conn, $sqlChangePasswordUser) or die("Error: change password user");

echo $queryChangePasswordUser;
return;
