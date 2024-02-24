<?php
include_once("../database/conn.php");

$id_section = (int)$_POST['id_section'];
$new_description_section = addslashes($_POST['new_description_section']);

$sqlChangeDescriptionSection = "UPDATE sections SET description_section = '$new_description_section' WHERE id_section = $id_section";
$queryChangeDescriptionSection = mysqli_query($conn, $sqlChangeDescriptionSection) or die("Error: change section's description");

echo $queryChangeDescriptionSection;
return;
