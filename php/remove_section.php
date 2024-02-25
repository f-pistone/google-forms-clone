<?php
include_once("../database/conn.php");

$id_section = (int)$_POST['id_section'];

$sqlGetSectionQuestions = "SELECT id_question FROM questions WHERE id_section = $id_section";
$queryGetSectionQuestions = mysqli_query($conn, $sqlGetSectionQuestions) or die("Error: get section's questions");
while ($rowGetSectionQuestions = mysqli_fetch_assoc($queryGetSectionQuestions)) {
  $id_question = (int)$rowGetSectionQuestions['id_question'];
  $sqlRemoveQuestionOptions = "DELETE FROM options WHERE id_question = $id_question";
  $queryRemoveQuestionOptions = mysqli_query($conn, $sqlRemoveQuestionOptions) or die("Error: remove question's options");
}

$sqlRemoveSectionQuestions = "DELETE FROM questions WHERE id_section = $id_section";
$queryRemoveSectionQuestions = mysqli_query($conn, $sqlRemoveSectionQuestions) or die("Error: remove section's questions");

$sqlRemoveSection = "DELETE FROM sections WHERE id_section = $id_section";
$queryRemoveSection = mysqli_query($conn, $sqlRemoveSection) or die("Error: remove section");

echo $queryRemoveSection;
return;
