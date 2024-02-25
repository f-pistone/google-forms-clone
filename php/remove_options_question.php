<?php
include_once("../database/conn.php");

$id_question = (int)$_POST['id_question'];

$sqlRemoveOptionsQuestion = "DELETE FROM options WHERE id_question = $id_question";
$queryRemoveOptionsQuestion = mysqli_query($conn, $sqlRemoveOptionsQuestion) or die("Error: remove options");

echo $queryRemoveOptionsQuestion;
return;
