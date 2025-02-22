<?php

include "connect.php";
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input values
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    //echo $password ." ". $confirm_password;
    
    // Check for empty fields
    if (empty($name) || empty($email) || empty($phone) || empty($city) || empty($password) || empty($confirm_password)) {
        die("All fields are required!");
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords  not match!");
    }

    // Hash the password for security
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

  

    // Prepare SQL statement
    $sql = "INSERT INTO users (name, email, phone, city, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $phone, $city,$password);

    if ($stmt->execute()) {
        echo "Registration !";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
