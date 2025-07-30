<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$payment = $_POST['payment_method'];
$status = "Placed";

$conn->begin_transaction(); // 🔄 START TRANSACTION

try {
    // Step 1: Get cart items with current stock
    $result = $conn->query("SELECT cart.Product_ID, products.Price, cart.Quantity, products.Stock_Quantity 
                            FROM cart 
                            JOIN products ON cart.Product_ID = products.Product_ID 
                            WHERE cart.User_ID = $user_id");

    $total = 0;
    $items = [];

    while ($row = $result->fetch_assoc()) {
        $cartQty = (int)$row['Quantity'];
        $stockQty = (int)$row['Stock_Quantity'];

        // Log what we’re comparing
        error_log("Checking stock for Product_ID {$row['Product_ID']}: cartQty=$cartQty, stockQty=$stockQty");

        if ($cartQty > $stockQty) {
            error_log("❌ Not enough stock for {$row['Product_ID']}");
            throw new Exception("❌ Not enough stock for '{$row['Product_ID']}'. Only {$stockQty} available.");
        }

        // Ensure correct data is passed forward
        $items[] = [
            'Product_ID' => $row['Product_ID'],
            'Quantity' => $cartQty,
            'Price' => $row['Price']
        ];
        $total += $row['Price'] * $cartQty;
    }


    // Step 2: Insert into orders
    $conn->query("INSERT INTO orders (User_ID, Total_Amount, Payment_Method, Order_Status) 
                  VALUES ($user_id, $total, '$payment', '$status')");
    $order_id = $conn->insert_id;

    // Step 3: Insert into order_items and reduce stock
    foreach ($items as $item) {
        $pid = $item['Product_ID'];
        $qty = $item['Quantity'];
        $price = $item['Price'];

        $conn->query("INSERT INTO order_items (Order_ID, Product_ID, Quantity, Price) 
                      VALUES ($order_id, $pid, $qty, $price)");

        $conn->query("UPDATE products SET Stock_Quantity = Stock_Quantity - $qty WHERE Product_ID = $pid");
    }

    // Step 4: Clear cart
    $conn->query("DELETE FROM cart WHERE User_ID = $user_id");

    $conn->commit(); // ✅ SUCCESS

    echo "✅ Order placed! Order ID: $order_id<br><a href='user_dashboard.php'>Back to Dashboard</a>";

} catch (Exception $e) {
    $conn->rollback(); // ❌ ROLLBACK on error
    echo "<p style='color:red;'>".$e->getMessage()."</p>";
    echo "<a href='user_dashboard.php?tab=cart'>Go back to Cart</a>";
}
?>
