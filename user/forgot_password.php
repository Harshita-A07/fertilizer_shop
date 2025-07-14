<?php
// user/forgot_password.php
session_start();
include('../connect.php'); // adjust if needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['reset_email'] = $email; // Save email to session
        header("Location: reset_password.html");
        exit;
    } else {
        echo "No account found with that email.<br><a href='forgot_password.html'>Try again</a>";
    }
}
?>
