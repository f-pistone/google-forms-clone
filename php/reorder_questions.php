<?php
include_once("../database/conn.php");

$ids_questions = json_decode($_POST['ids_questions']);
$id_section = (int)$_POST['id_section'];
$response = [];

foreach ($ids_questions as $index => $id_question) {
  $order_question = $index + 1;
  $id_question = (int)$id_question;
  $sqlReorderQuestion  = "UPDATE questions SET order_question = $order_question, id_section = $id_section WHERE id_question = $id_question";
  $queryReorderQuestion = mysqli_query($conn, $sqlReorderQuestion) or die("Error: reorder question");
  $response[] = $queryReorderQuestion;
}

header("Content-Type: application/json");
echo json_encode($response);
return;
