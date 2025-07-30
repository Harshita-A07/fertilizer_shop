<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        $update = "UPDATE cart SET Quantity = ? WHERE User_ID = ? AND Product_ID = ?";
        $stmt = $conn->prepare($update);
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        $stmt->execute();
    }
}

header("Location: view_cart.php");
exit;
?>
