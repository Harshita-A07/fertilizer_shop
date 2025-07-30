<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout - AgriShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to left, #d8f0ce, #92d5a2ff);
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .checkout-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #2e7d32;
            margin-bottom: 30px;
        }

        label {
            font-size: 16px;
            color: #333;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background-color: #46855f;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1b5e20;
        }
    </style>
</head>
<body>
    <form class="checkout-box" method="POST" action="place_order.php">
        <h2>Confirm Your Order</h2>
        <label for="payment_method">Payment Method:</label><br>
        <select name="payment_method" id="payment_method" required>
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="UPI">UPI</option>
            <option value="Credit Card">Credit Card</option>
        </select><br>
        <button type="submit">Place Order</button>
    </form>
</body>
</html>
