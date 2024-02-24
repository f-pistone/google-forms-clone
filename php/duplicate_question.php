<?php
include_once("../database/conn.php");

$id_question_to_clone = (int)$_POST['id_question_to_clone'];

$id_question = null;
$name_question = "";
$type_question = "";
$id_section = 0;
$answer_question = "";
$required_question = 0;
$order_question = 0;
$uniqid = uniqid("", true);

$sqlGetQuestionToClone = "SELECT * FROM questions WHERE id_question = $id_question_to_clone";
$queryGetQuestionToClone = mysqli_query($conn, $sqlGetQuestionToClone) or die("Error: get question to clone");

while ($rowGetQuestionToClone = mysqli_fetch_assoc($queryGetQuestionToClone)) {
  $name_question = addslashes($rowGetQuestionToClone['name_question']);
  $type_question = addslashes($rowGetQuestionToClone['type_question']);
  $id_section = (int)$rowGetQuestionToClone['id_section'];
  $answer_question = addslashes($rowGetQuestionToClone['answer_question']);
  $required_question = (int)$rowGetQuestionToClone['required_question'];
}

$sqlDuplicateQuestion = "INSERT INTO 
                          questions 
                            (name_question, type_question, id_section, answer_question, required_question, order_question, uniqid) 
                          VALUES 
                            ('$name_question', '$type_question', $id_section, '$answer_question', $required_question, $order_question, '$uniqid')";
$queryDuplicateQuestion = mysqli_query($conn, $sqlDuplicateQuestion) or die("Error: duplicate question");

$sqlGetIdDuplicateQuestion = "SELECT id_question FROM questions WHERE uniqid = '$uniqid'";
$queryGetIdDuplicateQuestion = mysqli_query($conn, $sqlGetIdDuplicateQuestion) or die("Error: get duplicate question id");
$rowGetIdDuplicateQuestion = mysqli_fetch_assoc($queryGetIdDuplicateQuestion);
$id_question = (int)$rowGetIdDuplicateQuestion['id_question'];

echo $id_question;
return;
