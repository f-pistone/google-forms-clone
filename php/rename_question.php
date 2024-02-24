<?php
include_once("../database/conn.php");

$id_question = (int)$_POST['id_question'];
$new_name_question = addslashes($_POST['new_name_question']);

$sqlRenameQuestion = "UPDATE questions SET name_question = '$new_name_question' WHERE id_question = $id_question";
$queryRenameQuestion = mysqli_query($conn, $sqlRenameQuestion) or die("Error: rename question");

echo $queryRenameQuestion;
return;
