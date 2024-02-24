<?php
include_once("../database/conn.php");

$id_question = (int)$_POST['id_question'];
$answer_question = json_decode($_POST['answer_question']);
$answer_question = implode(" | ", $answer_question);

$sqlUpdateQuestionAnswer = "UPDATE 
                            questions 
                          SET 
                            answer_question = '$answer_question' 
                          WHERE 
                            id_question = $id_question";
$queryUpdateQuestionAnswer = mysqli_query($conn, $sqlUpdateQuestionAnswer) or die("Error: update question answer");

echo $queryUpdateQuestionAnswer;
return;
