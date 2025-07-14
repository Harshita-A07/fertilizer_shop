<?php
include('../connect.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM Products";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $query .= " WHERE Name LIKE '%$search%' OR Category LIKE '%$search%' OR Description LIKE '%$search%'";
}

$result = $conn->query($query);
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
            align-items: center;
            margin-bottom: 20px;
        }

        .top-bar a, .top-bar button {
            background-color: #4caf50;
            padding: 8px 14px;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-box input[type="text"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 250px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 20px;
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
            display: inline-block;
            padding: 6px 12px;
            margin: 2px 4px;
          
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none
        }

        .edit-btn { background-color: #1976d2; }
        .delete-btn { background-color: #e53935; }
        .back-btn {
            background-color: #607d8b;
            margin-right: auto;
        }
        .back-button {
    display: inline-block;
    margin-bottom: 20px;
    background-color: #81c784;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 6px;
    font-size: 15px;
    font-weight: bold;
}

.back-button:hover {
    background-color: #66bb6a;
}

    </style>
</head>
<body>

<div class="container">
    <div class="top-bar">
        <form class="search-box" method="GET">
            <a href="../admin_dashboard.php" class="back-button">⬅️ Back to Dashboard</a>

            <input type="text" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
        <a href="add_product.php">+ Add New Product</a>
    </div>

    <h2>Manage Products</h2>

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
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['Product_ID'] ?></td>
                    <td><?= $row['Name'] ?></td>
                    <td><?= $row['Category'] ?></td>
                    <td><?= $row['Price'] ?></td>
                    <td><?= $row['Stock_Quantity'] ?></td>
                    <td><?= $row['Description'] ?></td>
                    <td>
                        <a class="btn edit-btn" href="edit_product.php?id=<?= $row['Product_ID'] ?>">Edit</a><br>
                        <a class="btn delete-btn" href="delete_product.php?id=<?= $row['Product_ID'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        <?php else: ?>
            <tr><td colspan="7">No products found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
