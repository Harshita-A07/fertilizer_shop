<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = new mysqli("localhost", "root", "", "fertilizersdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize input
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Check if passwords match
if ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match'); window.location.href='admin_register.html';</script>";
    exit();
}

// Check if admin already exists
$stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Admin already registered!'); window.location.href='admin_register.html';</script>";
    exit();
}

// Insert new admin with plain password
$stmt = $conn->prepare("INSERT INTO admin (Username, email, Password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password);

if ($stmt->execute()) {
    echo "<script>alert('Registration successful! Please login.'); window.location.href='admin_login.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
