<?php
include_once("../database/conn.php");

session_start();

$id_user = (int)$_SESSION['id_user'];
$new_email_user = addslashes($_POST['new_email_user']);

$sqlChangeEmailUser = "UPDATE 
                        users 
                      SET 
                        email_user = '$new_email_user'
                      WHERE 
                        id_user = $id_user";
$queryChangeEmailUser = mysqli_query($conn, $sqlChangeEmailUser) or die("Error: change email user");

echo $queryChangeEmailUser;
return;
