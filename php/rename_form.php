<?php
include_once("../database/conn.php");

$id_form = (int)$_POST['id_form'];
$new_title_form = addslashes($_POST['new_title_form']);

$sqlRenameForm = "UPDATE forms SET title_form = '$new_title_form' WHERE id_form = $id_form";
$queryRenameForm = mysqli_query($conn, $sqlRenameForm) or die("Error: rename form");

echo $queryRenameForm;
return;
