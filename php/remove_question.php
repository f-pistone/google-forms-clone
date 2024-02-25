<?php
include_once("../database/conn.php");

$id_question = (int)$_POST['id_question'];

$sqlRemoveOptions = "DELETE FROM options WHERE id_question = $id_question";
$queryRemoveOptions = mysqli_query($conn, $sqlRemoveOptions) or die("Error: remove question's options");

$sqlRemoveQuestion = "DELETE FROM questions WHERE id_question = $id_question";
$queryRemoveQuestion = mysqli_query($conn, $sqlRemoveQuestion) or die("Error: remove question");

echo $queryRemoveQuestion;
return;
