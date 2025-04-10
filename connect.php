<?php

  // Database connection
  $servername = "localhost";
  $username = "root";
  $password_db = "";  // Default password for XAMPP
  $dbname = "fertilizersdb";
  $port="3306";
  $servername = "127.0.0.1";



$conn = new mysqli($servername, $username, $password_db, $dbname,$port);
echo "done";
mysqli_set_charset($conn, "utf8");

// $current_charset = mysqli_character_set_name($conn);

// echo "Current character set: " . $current_charset;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>