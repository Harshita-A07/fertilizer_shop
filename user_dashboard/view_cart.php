<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>Please log in to view your cart.</p>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Get cart items with product details
$query = "
    SELECT cart.Product_ID, products.Name, products.Price, cart.Quantity, (products.Price * cart.Quantity) AS Total
    FROM cart
    JOIN products ON cart.Product_ID = products.Product_ID
    WHERE cart.User_ID = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Shopping Cart</title>
    <link rel="stylesheet" href="../styles/cart.css"> <!-- link your CSS file -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2b7a2b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        table th, table td {
            padding: 15px;
            text-align: center;
        }
        table th {
            background-color: #7ed681ff;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        input[type=number] {
            width: 60px;
            padding: 5px;
        }
        .btn {
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 15px;
            background-color: #90d092ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #3e8e41;
        }
        .total {
            margin-top: 20px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
        .remove-link {
            color: red;
            text-decoration: none;
        }
        .remove-link:hover {
            text-decoration: underline;
        }
        .bottom-actions {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Your Shopping Cart</h2>

    <form method="POST" action="update_cart.php">
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>

            <?php
            $total_cart_price = 0;
            while ($row = $result->fetch_assoc()) {
                $total_cart_price += $row['Total'];
                echo "<tr>
                        <td>{$row['Name']}</td>
                        <td>₹{$row['Price']}</td>
                        <td>
                            <input type='number' name='quantities[{$row['Product_ID']}]' value='{$row['Quantity']}' min='1'>
                        </td>
                        <td>₹{$row['Total']}</td>
                        <td><a class='remove-link' href='remove_item.php?product_id={$row['Product_ID']}'>Remove</a></td>
                    </tr>";
            }
            ?>
        </table>

        <p class="total">Cart Total: ₹<?php echo $total_cart_price; ?></p>

        <div class="bottom-actions">
    <a href="user_dashboard.php" class="btn" style="background-color: #777;">← Back to Shop</a>
    <button type="submit" class="btn">Update Quantities</button>
    <a href="checkout_address.php" class="btn">Proceed to Address & Checkout</a>
</div>

    </form>
</div>
</body>
</html>

<?php $conn->close(); ?>
