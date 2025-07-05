<?php
include('../connect.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$statusMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    $insert = "INSERT INTO Products (Name, Category, Price, Stock_Quantity, Description)
               VALUES ('$name', '$category', '$price', '$stock', '$description')";

    if ($conn->query($insert)) {
        header("Location: manage_products.php?status=added");
        exit();
    } else {
        $statusMessage = "<p class='error'>Error adding product. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add New Product</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e6f4ea;
            color: #333;
        }

        .form-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 12px;
            font-weight: bold;
        }

        input, textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 5px;
        }

        textarea {
            resize: vertical;
        }

        button {
            margin-top: 20px;
            padding: 12px;
            background-color: #4caf50;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #388e3c;
        }

        .error {
            color: red;
            text-align: center;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #1976d2;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add New Product</h2>

    <?php if (!empty($statusMessage)) echo $statusMessage; ?>

    <form method="POST">
        <label for="name">Product Name:</label>
        <input type="text" name="name" required>

        <label for="category">Category:</label>
        <input type="text" name="category" required>

        <label for="price">Price (₹):</label>
        <input type="number" name="price" step="0.01" min="0" required>

        <label for="stock">Stock Quantity:</label>
        <input type="number" name="stock" min="0" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" required></textarea>

        <button type="submit">Add Product</button>
    </form>

    <a class="back-link" href="manage_products.php">← Back to Manage Products</a>
</div>

</body>
</html>
