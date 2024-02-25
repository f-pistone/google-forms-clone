<?php
include_once("../database/conn.php");

$id_form = (int)$_POST['id_form'];

//Get the form's section
$sqlGetFormSections = "SELECT id_section FROM sections WHERE id_form = $id_form";
$queryGetFormSections = mysqli_query($conn, $sqlGetFormSections) or die("Error: get form's sections");

while ($rowGetFormSections = mysqli_fetch_assoc($queryGetFormSections)) {
  $id_section = (int)$rowGetFormSections['id_section'];

  //Get the section's questions
  $sqlGetSectionQuestions = "SELECT id_question FROM questions WHERE id_section = $id_section";
  $queryGetSectionQuestions = mysqli_query($conn, $sqlGetSectionQuestions) or die("Error: get form's section's questions");

  //Remove the section's question's options
  while ($rowGetSectionQuestions = mysqli_fetch_assoc($queryGetSectionQuestions)) {
    $id_question = (int)$rowGetSectionQuestions['id_question'];
    $sqlRemoveQuestionOptions = "DELETE FROM options WHERE id_question = $id_question";
    $queryRemoveQuestionOptions = mysqli_query($conn, $sqlRemoveQuestionOptions) or die("Error: remove form's section's question's options");
  }

  //Remove the section's questions
  $sqlRemoveSectionQuestions = "DELETE FROM questions WHERE id_section = $id_section";
  $queryRemoveSectionQuestions = mysqli_query($conn, $sqlRemoveSectionQuestions) or die("Error: remove form's section's questions");
}

//Remove the form's section
$sqlRemoveFormSections = "DELETE FROM sections WHERE id_form = $id_form";
$queryRemoveFormSections = mysqli_query($conn, $sqlRemoveFormSections) or die("Error: remove form's sections");

//Remove the form
$sqlRemoveForm = "DELETE FROM forms WHERE id_form = $id_form";
$queryRemoveForm = mysqli_query($conn, $sqlRemoveForm) or die("Error: remove form");

echo $queryRemoveForm;
return;
