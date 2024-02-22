<?php
include_once("../database/conn.php");

$question_types = [];
$sqlGetQuestionTypes = "SELECT * FROM question_types ORDER BY order_question_type ASC";
$queryGetQuestionTypes = mysqli_query($conn, $sqlGetQuestionTypes) or die("Error: get question types");
while ($rowGetQuestionTypes = mysqli_fetch_assoc($queryGetQuestionTypes)) {
  $question_types[] = [
    'id_question_type' => (int)$rowGetQuestionTypes['id_question_type'],
    'name_question_type' => $rowGetQuestionTypes['name_question_type']
  ];
}

header("Content-Type: application/json");
echo json_encode($question_types);
