<?php
include_once("../database/conn.php");

session_start();

$id_user = (int)$_SESSION['id_user'];
$title_form = "Form without a title";
$image_form = "./assets/images/form-image-placeholder.png";
$uniqid_form = uniqid("", true);

$sqlCreateForm = "INSERT INTO forms (title_form, image_form, id_user, uniqid) VALUES ('$title_form', '$image_form', $id_user, '$uniqid_form')";
$queryCreateForm = mysqli_query($conn, $sqlCreateForm) or die("Error: create form");

$sqlGetIdForm = "SELECT id_form FROM forms WHERE uniqid = '$uniqid_form'";
$queryGetIdForm = mysqli_query($conn, $sqlGetIdForm) or die("Error: get form id");
$rowGetIdForm = mysqli_fetch_assoc($queryGetIdForm);
$id_form = (int)$rowGetIdForm['id_form'];

$title_section = "Section without a title";
$order_section = 1;
$uniqid_section = uniqid("", true);

$sqlCreateFirstSection = "INSERT INTO sections (title_section, id_form, order_section, uniqid) VALUES ('$title_section', $id_form, $order_section, '$uniqid_section')";
$queryCreateFirstSection = mysqli_query($conn, $sqlCreateFirstSection) or die("Error: create first section");

echo $id_form;
return;
