<?php
session_start();
include('connect.php');
if (!isset($_SESSION['user_id'])) {
    header("Location:admin_login.html");
    exit();
}

// Counts for summary cards
$userResult = $conn->query("SELECT COUNT(*) AS total FROM Users");
$totalUsers = $userResult->fetch_assoc()['total'];

$productResult = $conn->query("SELECT COUNT(*) AS total FROM Products");
$totalProducts = $productResult->fetch_assoc()['total'];

$blogResult = $conn->query("SELECT COUNT(*) AS total FROM blogs");
$totalBlogs = $blogResult->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #e9f5ec;
      display: flex;
    }

    .sidebar {
      width: 240px;
      background-color: #2c4d4d;
      color: white;
      height: 100vh;
      padding-top: 30px;
      position: fixed;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .sidebar a {
      display: block;
      padding: 15px 25px;
      color: white;
      text-decoration: none;
      font-size: 18px;
    }

    .sidebar a:hover {
      background-color: #3e6e6e;
    }

    .main {
      margin-left: 240px;
      padding: 40px;
      width: calc(100% - 240px);
    }

    .welcome {
      background: #d6f5d6;
      padding: 25px;
      border-radius: 10px;
      color: #234d20;
      margin-bottom: 30px;
    }

    .welcome h1 {
      margin: 0 0 10px 0;
    }

    .card-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 25px;
    }

    .card {
      background: white;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      text-align: center;
      transition: transform 0.2s;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card i {
      font-size: 36px;
      margin-bottom: 10px;
      color: #2c4d4d;
    }

    .card h3 {
      margin: 10px 0 5px;
    }

    .card p {
      font-size: 20px;
      color: #234d20;
      font-weight: bold;
    }

    .notes {
      background: #fffbe0;
      padding: 20px;
      margin-top: 40px;
      border-radius: 10px;
      color: #665c00;
    }

    .notes ul {
      margin-top: 10px;
      padding-left: 20px;
    }

    .logout {
      position: absolute;
      bottom: 30px;
      width: 100%;
      text-align: center;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>🌿 Admin Panel</h2>
    <a href="admin_dashboard.php"><i class='bx bx-home'></i> Dashboard</a>
    <a href="/fertilizershop/admin_products/manage_products.php"><i class='bx bx-box'></i> Manage Products</a>
    <a href="manage_users.php"><i class='bx bx-user'></i> Manage Users</a>
    <a href="post_blog_form.php"><i class='bx bx-pencil'></i> Post Blog</a>
    <div class="logout">
      <a href="/logout_userdashboard.php"><i class='bx bx-log-out'></i> Logout</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="welcome">
      <h1>Welcome, <?= $_SESSION['username'] ?? 'Admin' ?>! 🌱</h1>
      <p>Manage your fertilizer shop operations from this dashboard.</p>
    </div>

    <!-- Summary Cards -->
    <div class="card-container">
      <div class="card">
        <i class='bx bx-user'></i>
        <h3>Total Users</h3>
        <p><?= $totalUsers ?></p>
      </div>
      <div class="card">
        <i class='bx bx-box'></i>
        <h3>Total Products</h3>
        <p><?= $totalProducts ?></p>
      </div>
      <div class="card">
        <i class='bx bx-pencil'></i>
        <h3>Total Blogs</h3>
        <p><?= $totalBlogs ?></p>
      </div>
    </div>

    <!-- Admin Notes -->
    <div class="notes">
      <h2>📌 Admin Notes</h2>
      <ul>
        <li>🛒 Check for low stock products</li>
        <li>📝 Post a blog this week</li>
        <li>👤 Review recent user signups</li>
      </ul>
    </div>
  </div>

</body>
</html>
