<?php
include_once("../database/conn.php");

session_start();

$response = [];

if ($_FILES['new_image_user']['error'] != 0) {
  $response['result'] = -1;
  header("Content-Type: application/json");
  echo json_encode($response);
  return;
}

$name = $_FILES['new_image_user']['name'];
$tmp_name = $_FILES['new_image_user']['tmp_name'];

$document_root = $_SERVER['DOCUMENT_ROOT'];
$server_name = $_SERVER['SERVER_NAME'];
$upload_dir = "uploads/images/";
$new_name = date("YmdHis") . "-" . strtolower(str_replace(" ", "-", trim(basename($name))));
$new_image_user = $upload_dir . $new_name;

move_uploaded_file($tmp_name, "../$new_image_user");

if (!file_exists("../$new_image_user")) {
  $response['result'] = -2;
  header("Content-Type: application/json");
  echo json_encode($response);
  return;
}

$id_user = (int)$_SESSION['id_user'];

$sqlGetOldImageUser = "SELECT image_user FROM users WHERE id_user = $id_user";
$queryGetOldImageUser = mysqli_query($conn, $sqlGetOldImageUser) or die("Error: get old image user");
$rowGetOldImageUser = mysqli_fetch_assoc($queryGetOldImageUser);
$old_image_user = "../" . $rowGetOldImageUser['image_user'];

if (file_exists($old_image_user)) {
  unlink($old_image_user);
}

$sqlChangeImageUser = "UPDATE 
                        users 
                      SET 
                        image_user = '$new_image_user' 
                      WHERE 
                        id_user = $id_user";
$queryChangeImageUser = mysqli_query($conn, $sqlChangeImageUser) or die("Error: change image user");

$response = [
  'result' => $queryChangeImageUser,
  'new_image_user' => $new_image_user
];

header("Content-Type: application/json");
echo json_encode($response);
return;
