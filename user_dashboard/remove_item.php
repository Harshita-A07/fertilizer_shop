<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'];

$delete = "DELETE FROM cart WHERE User_ID = ? AND Product_ID = ?";
$stmt = $conn->prepare($delete);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();

header("Location: view_cart.php");
exit;
?>
