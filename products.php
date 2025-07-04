<?php
include('connect.php');
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
    <title>Manage Products</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        a { margin: 0 5px; text-decoration: none; }
        .add-btn { display: inline-block; padding: 10px; background: green; color: white; text-decoration: none; }
    </style>
</head>
<body>
     
    <h2>Products List</h2>
    <a href="add_product.php" class="add-btn">+ Add New Product</a>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Price</th><th>Description</th><th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['Product_ID'] ?></td>
            <td><?= $row['Name'] ?></td>
            <td><?= $row['Price'] ?></td>
            <td><?= $row['Description'] ?></td>
            <td>
                <a href="edit_product.php?id=<?= $row['Product_ID'] ?>">Edit</a> |
                <a href="delete_product.php?id=<?= $row['Product_ID'] ?>" onclick="return confirm('Sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
