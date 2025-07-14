<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Blog Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f1f9f2;
      margin: 0;
      padding: 40px;
      text-align: center;
    }

    h1 {
      color: #2b4c3e;
      margin-bottom: 40px;
    }

    .button-container {
      display: flex;
      justify-content: center;
      gap: 30px;
      flex-wrap: wrap;
    }

    a {
      text-decoration: none;
    }

    .btn {
      padding: 15px 30px;
      background-color: #76b877;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #4e944f;
    }
  </style>
</head>
<body>

  <h1>Admin Blog Management</h1>

  <div class="button-container">
    <a href="../post_blog_form.php"><button class="btn">Post New Blog</button></a>
    <a href="../view_blog.php"><button class="btn"> View / Edit Blogs</button></a>
  </div>

</body>
</html>
