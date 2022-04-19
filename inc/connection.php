<?php
$db_servername = "localhost";
$db_username = "root";
$db_password = "pass";
$database_name = "cse311";

// Create connection
$conn = mysqli_connect($db_servername, $db_username, $db_password, $database_name);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
