<?php
include_once("../database/conn.php");

session_start();

$id_user = (int)$_SESSION['id_user'];
$new_first_name_user = addslashes($_POST['new_first_name_user']);
$new_last_name_user = addslashes($_POST['new_last_name_user']);

$sqlChangeNameUser = "UPDATE 
                        users 
                      SET 
                        first_name_user = '$new_first_name_user', last_name_user = '$new_last_name_user' 
                      WHERE 
                        id_user = $id_user";
$queryChangeNameUser = mysqli_query($conn, $sqlChangeNameUser) or die("Error: change name user");

echo $queryChangeNameUser;
return;
