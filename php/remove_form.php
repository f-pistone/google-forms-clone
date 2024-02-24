<?php
include_once("../database/conn.php");

$id_form = (int)$_POST['id_form'];

$sqlGetFormSections = "SELECT id_section FROM sections WHERE id_form = $id_form";
$queryGetFormSections = mysqli_query($conn, $sqlGetFormSections) or die("Error: get form's sections");

while ($rowGetFormQuestions = mysqli_fetch_assoc($queryGetFormSections)) {
  $id_section = (int)$rowGetFormQuestions['id_section'];
  $sqlRemoveSectionQuestions = "DELETE FROM questions WHERE id_section = $id_section";
  $queryRemoveSectionQuestions = mysqli_query($conn, $sqlRemoveSectionQuestions) or die("Error: remove form's section's questions");
}

$sqlRemoveFormSections = "DELETE FROM sections WHERE id_form = $id_form";
$queryRemoveFormSections = mysqli_query($conn, $sqlRemoveFormSections) or die("Error: remove form's sections");

$sqlRemoveForm = "DELETE FROM forms WHERE id_form = $id_form";
$queryRemoveForm = mysqli_query($conn, $sqlRemoveForm) or die("Error: remove form");

echo $queryRemoveForm;
return;
