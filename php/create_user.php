<?php
include_once("../database/conn.php");

$id_user = null;
$first_name_user = addslashes($_POST['first_name_user']);
$last_name_user = addslashes($_POST['last_name_user']);
$email_user = addslashes($_POST['email_user']);
$password_user = hash("sha256", $_POST['password_user']);
$uniqid = uniqid("", true);

$sqlCreateUser = "INSERT INTO 
          users 
            (first_name_user, last_name_user, email_user, password_user, uniqid) 
          VALUES 
            ('$first_name_user', '$last_name_user', '$email_user', '$password_user', '$uniqid')";
$queryCreateUser = mysqli_query($conn, $sqlCreateUser) or die("Error: create user");

$sqlGetUserId = "SELECT id_user FROM users WHERE uniqid = '$uniqid'";
$queryGetUserId = mysqli_query($conn, $sqlGetUserId) or die("Error: get user id");;
$row = mysqli_fetch_assoc($queryGetUserId);
$id_user = (int)$row['id_user'];

if (!empty($id_user) && $id_user > 0) {
  session_start();
  $_SESSION['id_user'] = $id_user;
}

echo $id_user;
