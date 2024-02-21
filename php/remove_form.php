<?php
include_once("../database/conn.php");

$id_form = (int)$_POST['id_form'];

$sqlRemoveForm = "DELETE FROM forms WHERE id_form = $id_form";
$queryRemoveForm = mysqli_query($conn, $sqlRemoveForm) or die("Error: remove form");

echo $queryRemoveForm;
return;
