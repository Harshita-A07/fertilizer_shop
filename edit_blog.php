<?php
include('connect.php');

if (!isset($_GET['id'])) {
    echo "No blog ID provided.";
    exit();
}

$blog_id = $_GET['id'];

// Fetch blog data
$query = "SELECT * FROM blogs WHERE Blog_ID = $blog_id";
$result = mysqli_query($conn, $query);
$blog = mysqli_fetch_assoc($result);

if (!$blog) {
    echo "Blog not found.";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_path = $blog['Image_Path']; // default to old image

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // Delete old image
        if (!empty($blog['Image_Path']) && file_exists($blog['Image_Path'])) {
            unlink($blog['Image_Path']);
        }

        // Upload new image
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = 'uploads/' . $image_name;

        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }

        move_uploaded_file($image_tmp, $image_path);
    }

    // Update blog
    $update_query = "UPDATE blogs SET Title='$title', Content='$content', Image_Path='$image_path' WHERE Blog_ID=$blog_id";
    if (mysqli_query($conn, $update_query)) {
        header("Location: post_blog_form.php?status=updated");
        exit();
    } else {
        echo "Error updating blog.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Blog</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input, textarea { width: 100%; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Edit Blog Post</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Blog Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($blog['Title']) ?>" required>

        <label>Upload New Image:</label>
        <?php if (!empty($blog['Image_Path'])): ?>
            <p>Current Image: <img src="<?= $blog['Image_Path'] ?>" width="150"></p>
        <?php endif; ?>
        <input type="file" name="image" accept="image/*">

        <label>Content:</label>
        <textarea name="content" rows="6" required><?= htmlspecialchars($blog['Content']) ?></textarea>

        <button type="submit">Update Blog</button>
    </form>
</body>
</html>
