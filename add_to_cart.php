<?php
session_start();
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];

    // Fetch product from DB
    $stmt = $conn->prepare("SELECT * FROM Products WHERE Product_ID = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $cartItem = [
            'id' => $product['Product_ID'],
            'name' => $product['Name'],
            'price' => $product['Price'],
            'qty' => 1
        ];

        // Initialize cart if not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;
        // If already in cart, increase qty
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product['Product_ID']) {
                $item['qty']++;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $cartItem;
        }
    }

    header("Location: user_dashboard.php?tab=cart");
    exit();
}
?>
