<?php
include('connect.php'); // include your DB connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $city     = trim($_POST['city']); // Not stored in DB, unless added to the table

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // OPTIONAL: You can hash passwords here if you want more security
    // $password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the Users table
    $sql = "INSERT INTO Users (Name, Password, Email, Phone)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $password, $email, $phone);

    if ($stmt->execute()) {
        echo "Registration successful! <a href='login.html'>Login Now</a>";
    } else {
        // Handle duplicate email or name
        if ($conn->errno == 1062) {
            echo "User already exists with this name or email.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
    $conn->close();
} else {
    echo "\n Invalid request!";
}
?>
