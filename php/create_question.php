<?php
include_once("../database/conn.php");

$id_section = (int)$_POST['id_section'];
$type_question = "SHORT_ANSWER";
$order_question = 0;
$uniqid = uniqid("", true);

$sqlGetLastOrderQuestion = "SELECT MAX(order_question) AS last_order_question FROM questions WHERE id_section = $id_section";
$queryGetLastOrderQuestion = mysqli_query($conn, $sqlGetLastOrderQuestion) or die("Error: get last order question");
$rowGetLastOrderQuestion = mysqli_fetch_assoc($queryGetLastOrderQuestion);
$orderLastQuestion = (int)$rowGetLastOrderQuestion['last_order_question'];
$order_question = $orderLastQuestion + 1;

$sqlCreateQuestion = "INSERT INTO 
                        questions 
                          (id_section, type_question, order_question, uniqid) 
                        VALUES 
                          ($id_section, '$type_question', $order_question, '$uniqid')";
$queryCreateQuestion = mysqli_query($conn, $sqlCreateQuestion) or die("Error: create question");

$sqlGetIdQuestion = "SELECT id_question FROM questions WHERE uniqid = '$uniqid'";
$queryGetIdQuestion = mysqli_query($conn, $sqlGetIdQuestion) or die("Error: get question id");
$rowGetIdQuestion = mysqli_fetch_assoc($queryGetIdQuestion);
$id_question = (int)$rowGetIdQuestion['id_question'];

echo $id_question;
return;
