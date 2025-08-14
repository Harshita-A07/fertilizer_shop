<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Our Blogs - AgriShop</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0fff4;
      color: #2e4d2e;
      margin: 0;
    }

    header {
      background-color: #d9f8d6;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #2e4d2e;
      display: flex;
      align-items: center;
    }

    .logo i {
      margin-right: 8px;
    }

    .blog-container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
    }

    .blog-card {
      background-color: #ffffff;
      border-radius: 8px;
      margin-bottom: 30px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      overflow: hidden;
    }

    .blog-card img {
      width: 100%;
      height: 250px;
      object-fit: cover;
    }

    .blog-content {
      padding: 20px;
    }

    .blog-content h3 {
      margin-top: 0;
    }

    .blog-content p {
      font-size: 16px;
      color: #466f46;
    }

    .read-more {
      display: inline-block;
      margin-top: 10px;
      padding: 10px 18px;
      background-color: #2e4d2e;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
    }

    .read-more:hover {
      background-color: #1a3f1a;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo"><i class="ri-leaf-fill"></i>AgriShop Blogs</div>
  </header>
<h2>Do login to our website to read further blogs</h2>
  <!-- Blog Content -->
  <div class="blog-container">

    <!-- Blog Post 1 -->
    <div class="blog-card">
      <img src="assets/blog1.jpg" alt="Blog 1">
      <div class="blog-content">
        <h3>5 Tips for Organic Farming</h3>
        <p>Organic farming is gaining momentum. Learn how to get started using natural compost, pest control, and more.</p>
        <a href="<?php echo isset($_SESSION['user_id']) ? 'view_blog.php?id=1' : 'user/login.html'; ?>" class="read-more">Read More</a>
      </div>
    </div>

    <!-- Blog Post 2 -->
    <div class="blog-card">
      <img src="assets/blog2.jpg" alt="Blog 2">
      <div class="blog-content">
        <h3>Choosing the Right Fertilizer for Your Crop</h3>
        <p>Each crop requires specific nutrients. Learn how to pick the right fertilizer and improve your yield.</p>
        <a href="<?php echo isset($_SESSION['user_id']) ? 'view_blog.php?id=2' : 'user/login.html'; ?>" class="read-more">Read More</a>
      </div>
    </div>

  </div>

</body>
</html>
