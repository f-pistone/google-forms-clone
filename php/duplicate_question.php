<?php
include_once("../database/conn.php");

$id_question_to_clone = (int)$_POST['id_question_to_clone'];

$response = [
  'id_question' => null,
  'ids_options' => []
];
$id_question = null;
$name_question = "";
$type_question = "";
$id_section = 0;
$answer_question = "";
$required_question = 0;
$order_question = 0;
$uniqid = uniqid("", true);

//Duplicate the question
$sqlGetQuestionToClone = "SELECT * FROM questions WHERE id_question = $id_question_to_clone";
$queryGetQuestionToClone = mysqli_query($conn, $sqlGetQuestionToClone) or die("Error: get question to clone");

while ($rowGetQuestionToClone = mysqli_fetch_assoc($queryGetQuestionToClone)) {
  $name_question = addslashes($rowGetQuestionToClone['name_question']);
  $type_question = addslashes($rowGetQuestionToClone['type_question']);
  $id_section = (int)$rowGetQuestionToClone['id_section'];
  $required_question = (int)$rowGetQuestionToClone['required_question'];
}

$sqlDuplicateQuestion = "INSERT INTO 
                          questions 
                            (name_question, type_question, id_section, required_question, order_question, uniqid) 
                          VALUES 
                            ('$name_question', '$type_question', $id_section, $required_question, $order_question, '$uniqid')";
$queryDuplicateQuestion = mysqli_query($conn, $sqlDuplicateQuestion) or die("Error: duplicate question");

$sqlGetIdDuplicateQuestion = "SELECT id_question FROM questions WHERE uniqid = '$uniqid'";
$queryGetIdDuplicateQuestion = mysqli_query($conn, $sqlGetIdDuplicateQuestion) or die("Error: get duplicate question id");
$rowGetIdDuplicateQuestion = mysqli_fetch_assoc($queryGetIdDuplicateQuestion);
$id_question = (int)$rowGetIdDuplicateQuestion['id_question'];

//Duplicate the options of the question
if ($type_question == "MULTIPLE_CHOISE" || $type_question == "CHECKBOX" || $type_question == "LIST") {

  $sqlGetOptionsToClone = "SELECT * FROM options WHERE id_question = $id_question_to_clone";
  $queryGetOptionsToClone = mysqli_query($conn, $sqlGetOptionsToClone) or die("Error: get options to clone");

  while ($rowGetOptionsToClone = mysqli_fetch_assoc($queryGetOptionsToClone)) {
    $name_option = addslashes($rowGetOptionsToClone['name_option']);
    $other_option = (int)$rowGetOptionsToClone['other_option'];
    $uniqid_option = uniqid("", true);

    $sqlDuplicateOptions = "INSERT INTO 
                            options 
                              (name_option, other_option, id_question, uniqid) 
                            VALUES 
                              ('$name_option', $other_option, $id_question, '$uniqid_option')";
    $queryDuplicateOptions = mysqli_query($conn, $sqlDuplicateOptions) or die("Error: duplicate options");

    $sqlGetIdDuplicateOption = "SELECT id_option FROM options WHERE uniqid = '$uniqid_option'";
    $queryGetIdDuplicateOption = mysqli_query($conn, $sqlGetIdDuplicateOption) or die("Error: get duplicate option id");
    $rowGetIdDuplicateOption = mysqli_fetch_assoc($queryGetIdDuplicateOption);
    $response['ids_options'][] = (int)$rowGetIdDuplicateOption['id_option'];
  }
}

$response['id_question'] = $id_question;

header("Content-Type: application/json");
echo json_encode($response);
return;
