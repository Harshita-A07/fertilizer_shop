<?php
session_start();
include('../connect.php');

if (!isset($_GET['product_id'])) {
    header("Location: user_dashboard.php?tab=products");
    exit();
}

$product_id = intval($_GET['product_id']);
$query = "SELECT * FROM Products WHERE Product_ID = $product_id";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    echo "<h2>Product not found.</h2>";
    exit();
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['Name']) ?> - Product Details</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            gap: 30px;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
        }

        .details {
            flex: 1;
        }

        .details h2 {
            margin-top: 0;
            color: #2c4d4d;
        }

        .price {
            font-size: 24px;
            color: #388e3c;
            margin: 15px 0;
        }

        .description {
            margin-bottom: 20px;
            color: #555;
        }

        input[type="number"] {
            width: 60px;
            padding: 6px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 10px;
            margin-right: 10px;
        }

        .cart-btn {
            background-color: #2c4d4d;
            color: white;
        }

        .bag-btn {
            background-color: #607d8b;
            color: white;
        }

        .back-link {
            display: inline-block;
            margin-top: 30px;
            color: #2c4d4d;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div style="flex: 1;">
        <img src="../<?= htmlspecialchars($product['Image_Path']) ?>" alt="<?= $product['Name'] ?>">
    </div>
    <div class="details">
        <h2><?= $product['Name'] ?></h2>
        <p class="price">₹<?= $product['Price'] ?></p>
        <p class="description"><?= $product['Description'] ?></p>

        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="product_id" value="<?= $product['Product_ID'] ?>">
            <label for="qty">Quantity:</label>
            <input type="number" name="qty" id="qty" value="1" min="1">
            <button type="submit" class="btn cart-btn">Add to Cart</button>
        </form>

        <form method="POST" action="add_to_bag.php">
            <input type="hidden" name="product_id" value="<?= $product['Product_ID'] ?>">
            <button type="submit" class="btn bag-btn">Add to Bag</button>
        </form>

        <a class="back-link" href="user_dashboard.php?tab=products">⬅️ Back to Products</a>
    </div>
</div>

</body>
</html>
