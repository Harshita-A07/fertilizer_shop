<?php
// user/reset_password.php
session_start();
include('../connect.php');

if (!isset($_SESSION['reset_email'])) {
    echo "Session expired. Please restart the reset process. <a href='forgot_password.html'>Go back</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['reset_email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        echo "Passwords do not match. <a href='reset_password.html'>Try again</a>";
        exit;
    }

    // Optional: Hash the password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->execute([$hashedPassword, $email]);

    // Clear session
    unset($_SESSION['reset_email']);

    echo "Password reset successfully. <a href='login.html'>Login</a>";
}
?>
