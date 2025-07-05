<?php
session_start();
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE Username='$name' AND Password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['Admin_ID'];
        $_SESSION['username'] = $row['Name'];
        $_SESSION['success_message'] = "Login successful! Welcome, " . $row['Name'] . ".";
        header("Location: admin_dashboard.php");

        
        exit();
    } else {
        echo "<script>alert('Invalid login'); window.location.href='login.html';</script>";
    }
}
?>
