<?php
include_once("../database/conn.php");

$id_form = (int)$_POST['id_form'];
$title_section = "Section without a title";
$order_section = 0;
$uniqid = uniqid("", true);

$sqlGetLastOrderSection = "SELECT MAX(order_section) AS last_order_section FROM sections WHERE id_form = $id_form";
$queryGetLastOrderSection = mysqli_query($conn, $sqlGetLastOrderSection) or die("Error: get last order section");
$rowGetLastOrderSection = mysqli_fetch_assoc($queryGetLastOrderSection);
$orderLastSection = (int)$rowGetLastOrderSection['last_order_section'];
$order_section = $orderLastSection + 1;

$sqlCreateSection = "INSERT INTO 
                        sections 
                          (title_section, id_form, order_section, uniqid) 
                        VALUES 
                          ('$title_section', $id_form, $order_section, '$uniqid')";
$queryCreateSection = mysqli_query($conn, $sqlCreateSection) or die("Error: create section");

$sqlGetIdSection = "SELECT id_section FROM sections WHERE uniqid = '$uniqid'";
$queryGetIdSection = mysqli_query($conn, $sqlGetIdSection) or die("Error: get section id");
$rowGetIdSection = mysqli_fetch_assoc($queryGetIdSection);
$id_section = (int)$rowGetIdSection['id_section'];

echo $id_section;
return;
