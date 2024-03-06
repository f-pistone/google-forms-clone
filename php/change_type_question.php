<?php
include_once("../database/conn.php");

$id_question = (int)$_POST['id_question'];
$new_type_question = addslashes($_POST['new_type_question']);

$sqlChangeTypeQuestion = "UPDATE 
                            questions 
                          SET 
                            type_question = '$new_type_question' 
                          WHERE 
                            id_question = $id_question";
$queryChangeTypeQuestion = mysqli_query($conn, $sqlChangeTypeQuestion) or die("Error: change type question");

echo $queryChangeTypeQuestion;
return;
