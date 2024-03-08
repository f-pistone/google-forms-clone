<?php

require './vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable("./");
$dotenv->load();

$hostname = $_ENV["DATABASE_HOSTNAME"];
$username = $_ENV["DATABASE_USERNAME"];
$password = $_ENV["DATABASE_PASSWORD"];
$database = $_ENV["DATABASE_DATABASE"];

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
