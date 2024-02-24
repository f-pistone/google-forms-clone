<?php
include_once("../database/conn.php");

$id_section = (int)$_POST['id_section'];

$sqlRemoveSectionQuestions = "DELETE FROM questions WHERE id_section = $id_section";
$queryRemoveSectionQuestions = mysqli_query($conn, $sqlRemoveSectionQuestions) or die("Error: remove section's questions");

$sqlRemoveSection = "DELETE FROM sections WHERE id_section = $id_section";
$queryRemoveSection = mysqli_query($conn, $sqlRemoveSection) or die("Error: remove section");

echo $queryRemoveSection;
return;
