<?php
session_start();
include '../connect.php'; // Your DB connection file
var_dump($_POST);  // Put at the top of add_to_cart.php
exit;


if (!isset($_SESSION['user_id'])) {
    echo "Please log in to add to cart.";
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];  // Coming from form or AJAX
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

// Check if product is already in cart
$checkQuery = "SELECT * FROM cart WHERE User_ID = ? AND Product_ID = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If already in cart, just update quantity
    $updateQuery = "UPDATE cart SET Quantity = Quantity + ? WHERE User_ID = ? AND Product_ID = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
} else {
    // Else, insert new row
    $insertQuery = "INSERT INTO cart (User_ID, Product_ID, Quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
}

if ($stmt->execute()) {
    // Redirect to view cart page
    header("Location:user_dashboard.php?tab=cart");
    exit;
} else {
    echo "Error: " . $stmt->error;
}


$conn->close();
?>
