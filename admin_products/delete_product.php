<?php
include('../connect.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete product from table
    $delete = "DELETE FROM Products WHERE Product_ID = $product_id";

    if ($conn->query($delete)) {
        header("Location: manage_products.php?status=deleted");
        exit();
    } else {
        header("Location: manage_products.php?status=error");
        exit();
    }
} else {
    header("Location: manage_products.php");
    exit();
}
?>
