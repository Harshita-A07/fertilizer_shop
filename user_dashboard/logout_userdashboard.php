<?php
session_start();

// Destroy all session data
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/');
}

session_destroy();

// Redirect to login page
header("Location: ../front.html"); // go up one folder if login is in user/
exit();
