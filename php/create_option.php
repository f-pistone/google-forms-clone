<?php
include_once("../database/conn.php");

$id_question = (int)$_POST['id_question'];
$other_option = (int)$_POST['other_option'];
$name_option = ($other_option == 0) ? "Option" : "Other";
$uniqid = uniqid("", true);

$sqlCreateOption = "INSERT INTO 
                      options 
                        (name_option, other_option, id_question, uniqid) 
                      VALUES 
                        ('$name_option', $other_option, $id_question, '$uniqid')";
$queryCreateOption = mysqli_query($conn, $sqlCreateOption) or die("Error: create option");

$sqlGetIdOption = "SELECT id_option FROM options WHERE uniqid = '$uniqid'";
$queryGetIdOption = mysqli_query($conn, $sqlGetIdOption) or die("Error: get id option");
$rowGetIdOption = mysqli_fetch_assoc($queryGetIdOption);
$id_option = (int)$rowGetIdOption['id_option'];

echo $id_option;
return;
