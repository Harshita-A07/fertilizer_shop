<?php
session_start();
include('../connect.php'); // your DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Query to find user
    $sql = "SELECT * FROM Users WHERE Name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Match password
        if ($password === $user['Password']) {
            // Login successful
            $_SESSION['user_id'] = $user['User_ID'];
            $_SESSION['username'] = $user['Name'];

            header("Location:  /fertilizershop/user_dashboard/user_dashboard.php");
 // ✅ Redirect to dashboard
            exit();
        } else {
            // Incorrect password
            $_SESSION['error'] = "Incorrect password";
            header("Location: login.html");
            exit();
        }
    } else {
        // User not found
        $_SESSION['error'] = "User not found";
        header("Location: login.html");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
