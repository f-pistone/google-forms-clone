<?php
include_once("../database/conn.php");

$id_option = (int)$_POST['id_option'];
$new_name_option = addslashes($_POST['new_name_option']);

$sqlRenameOption = "UPDATE options SET name_option = '$new_name_option' WHERE id_option = $id_option";
$queryRenameOption = mysqli_query($conn, $sqlRenameOption) or die("Error: rename option");

echo $queryRenameOption;
return;
