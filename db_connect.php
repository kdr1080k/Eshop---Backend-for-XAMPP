<?php

// Credential to connect the DB with Script
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";


// Library Code to generate connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



?>