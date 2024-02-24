<?php
include_once("../database/conn.php");

$id_section = (int)$_POST['id_section'];
$new_title_section = addslashes($_POST['new_title_section']);

$sqlRenameSection = "UPDATE sections SET title_section = '$new_title_section' WHERE id_section = $id_section";
$queryRenameSection = mysqli_query($conn, $sqlRenameSection) or die("Error: rename section");

echo $queryRenameSection;
return;
