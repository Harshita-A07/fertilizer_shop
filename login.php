<?php
session_start();
include('connect.php'); // your DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    
    //echo "Received name: '$name'<br>";
//echo "Received password: '$password'<br>";


    // Query to find user
    $sql = "SELECT * FROM Users WHERE Name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    //echo "Number of rows found: " . $result->num_rows . "<br>";

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Match password
        if ($password === $user['Password']) {
            // Login successful
            $_SESSION['user_id'] = $user['User_ID'];
            $_SESSION['username'] = $user['Name'];
            echo "<script>alert('success');window.location.href='login.html';</script>";
            header("Location: user_dashboard.php"); // Redirect to dashboard or homepage
            die("Redirecting...");
            exit();
        } else {
            echo "<script>alert('Incorrect password');window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found');window.location.href='login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
