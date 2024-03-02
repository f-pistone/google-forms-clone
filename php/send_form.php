<?php
include_once("../database/conn.php");

header("Content-Type: application/json");
echo json_encode($_POST);
