<?php
include('../connect.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$result = $conn->query("SELECT * FROM Products");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e9f7ec;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .top-bar a {
            background-color: #4caf50;
            padding: 10px 15px;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
    padding: 12px 20px; /* wider horizontal padding */
    text-align: center;
    border-bottom: 1px solid #ccc;
    vertical-align: top;
}


        th {
            background-color: #c8e6c9;
        }

        tr:hover {
            background-color: #f1f8e9;
        }

        .btn {
            padding: 6px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }

        .edit-btn { background-color: #1976d2; }
        .delete-btn { background-color: #e53935; }
        tbody tr {
    height: 60px; /* increases row height */
}

td {
    padding: 15px 12px;
    vertical-align: middle;
}
tbody tr:not(:last-child) {
    border-bottom: 2px solid #e0f2e9;
}

        
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Products</h2>

    <div class="top-bar">
        <div></div>
        <a href="admin_products/add_product.php">+ Add New Product</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price (₹)</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['Product_ID'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['Category'] ?></td>
                <td><?= $row['Price'] ?></td>
                <td><?= $row['Stock_Quantity'] ?></td>
                <td><?= $row['Description'] ?></td>
                <td>
                    <a class="btn edit-btn" href="edit_product.php?id=<?= $row['Product_ID'] ?>">Edit</a>
                    <br>
                    <a class="btn delete-btn" href="delete_product.php?id=<?= $row['Product_ID'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
