<?php

  // Database connection
  $servername = "localhost";
  $username = "root";
  $password_db = "";  // Default password for XAMPP
  $dbname = "fertilizersdb";
  $port="3306";
 
$conn = new mysqli($servername, $username, $password_db, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// Set character set to UTF-8
mysqli_set_charset($conn, "utf8");
?>