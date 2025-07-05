<?php
session_start();

// Destroy all session variables
$_SESSION = array();

// Destroy the session cookie if it exists
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Destroy the session completely
session_destroy();

// Redirect to login page
header("Location: login.html");
exit();
?>
