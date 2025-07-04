<?php
include('connect.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete the user from the database
    $delete = "DELETE FROM Users WHERE User_ID = $user_id";

    if ($conn->query($delete)) {
        header("Location: manage_users.php?status=deleted");
        exit();
    } else {
        header("Location: manage_users.php?status=error");
        exit();
    }
} else {
    header("Location: manage_users.php");
    exit();
}
?>
