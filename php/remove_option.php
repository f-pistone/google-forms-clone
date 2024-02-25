<?php
include_once("../database/conn.php");

$id_option = (int)$_POST['id_option'];

$sqlRemoveOption = "DELETE FROM options WHERE id_option = $id_option";
$queryRemoveOption = mysqli_query($conn, $sqlRemoveOption) or die("Error: remove option");

echo $queryRemoveOption;
return;
