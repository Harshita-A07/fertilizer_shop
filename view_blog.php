<?php
include('connect.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>All Blog Posts</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0fdf4;
            color: #2b4c3e;
            margin: 0;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #388e3c;
            margin-bottom: 30px;
        }

        .status {
            color: green;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .blog-post {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 25px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .blog-post h3 {
            margin-top: 0;
            color: #2f6237;
        }

        .blog-post img {
            max-width: 100%;
            border-radius: 8px;
            margin: 10px 0;
        }

        .blog-post p {
            line-height: 1.6;
            white-space: pre-wrap;
        }

        .edit-btn {
            display: inline-block;
            margin-top: 12px;
            padding: 8px 16px;
            background-color: #76b877;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .edit-btn:hover {
            background-color: #4e944f;
        }

        .back-link {
            display: block;
            text-align: left;
            margin: 10px 0 30px 10px;
            font-size: 14px;
            color: #333;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <a class="back-link" href="admin_blog_dashboard.php">← Back to Blog Dashboard</a>

    <h2>All Blog Posts</h2>

    <?php
    if (isset($_GET['status']) && $_GET['status'] == 'success') {
        echo "<p class='status'>Blog posted successfully!</p>";
    }

    $result = mysqli_query($conn, "SELECT * FROM blogs ORDER BY Date_Posted DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='blog-post'>";
        echo "<h3>" . htmlspecialchars($row['Title']) . "</h3>";
        if (!empty($row['Image_Path'])) {
            echo "<img src='" . htmlspecialchars($row['Image_Path']) . "' alt='Blog Image'>";
        }
        echo "<p>" . htmlspecialchars($row['Content']) . "</p>";
        echo "<a class='edit-btn' href='edit_blog.php?id=" . $row['Blog_ID'] . "'>Edit</a>";
        echo "</div>";
    }
    ?>

</body>
</html>
