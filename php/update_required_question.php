<?php
include_once("../database/conn.php");

$id_question = (int)$_POST['id_question'];
$required_question = (int)$_POST['required_question'];

$sqlUpdateRequiredQuestion = "UPDATE 
                                questions 
                              SET 
                                required_question = $required_question 
                              WHERE 
                                id_question = $id_question";
$queryUpdateRequiredQuestion = mysqli_query($conn, $sqlUpdateRequiredQuestion) or die("Error: update required question");

echo $queryUpdateRequiredQuestion;
return;
