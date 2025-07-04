<?php
include('connect.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Blog Posts</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .blog-post { margin-bottom: 30px; border-bottom: 1px solid #ccc; padding-bottom: 20px; }
        img { max-width: 300px; }
        a.edit-btn { color: blue; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <h2>All Blog Posts</h2>

    <?php
    if (isset($_GET['status']) && $_GET['status'] == 'success') {
        echo "<p style='color: green;'>Blog posted successfully!</p>";
    }

    $result = mysqli_query($conn, "SELECT * FROM blogs ORDER BY Date_Posted DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='blog-post'>";
        echo "<h3>" . htmlspecialchars($row['Title']) . "</h3>";
        if (!empty($row['Image_Path'])) {
            echo "<img src='" . $row['Image_Path'] . "' alt='Blog Image'><br>";
        }
        echo "<p>" . nl2br(htmlspecialchars($row['Content'])) . "</p>";
        echo "<a class='edit-btn' href='edit_blog.php?id=" . $row['Blog_ID'] . "'>Edit</a>";
        echo "</div>";
    }
    ?>
</body>
</html>
