<?php
include('connect.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$result = $conn->query("SELECT * FROM Blog");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Blog</title>
    <link rel="stylesheet" href="admin_sidebar.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        a { margin: 0 5px; text-decoration: none; }
        .add-btn { display: inline-block; padding: 10px; background: #28a745; color: white; text-decoration: none; }
    </style>
</head>
<body>
    <!-- Include Sidebar -->
    <?php include('admin_sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            <h1>Manage Blog Posts</h1>
        </div>

        <!-- Blog Table -->
        <h2>Blog Posts</h2>
        <a href="add_blog.php" class="add-btn">+ Add New Blog</a>
        <table>
            <tr>
                <th>ID</th><th>Title</th><th>Content</th><th>Action</th>
            </tr>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['Blog_ID'] ?></td>
                <td><?= $row['Title'] ?></td>
                <td><?= substr($row['Content'], 0, 50) ?>...</td>
                <td>
                    <a href="edit_blog.php?id=<?= $row['Blog_ID'] ?>">Edit</a> |
                    <a href="delete_blog.php?id=<?= $row['Blog_ID'] ?>" onclick="return confirm('Sure?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>
</body>
</html>
