<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imagePath = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    // Insert blog (without image first)
    $query = "INSERT INTO blogs (Title, Content, Date_Posted) VALUES ('$title', '$content', NOW())";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $last_id = mysqli_insert_id($conn);

        // Update image path
        if (!empty($imagePath)) {
            $update = "UPDATE blogs SET Image_Path='$imagePath' WHERE Blog_ID=$last_id";
            mysqli_query($conn, $update);
        }

        // Redirect to view page
        header("Location: view_blog.php?status=success");
        exit();
    } else {
        $statusMessage = "<p class='error'>Error posting blog. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Post Blog</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #e6f4ea; /* pastel green */
      color: #333;
    }

    .main-content {
      margin-left: 250px;
      padding: 20px;
    }

    .topbar {
      display: flex;
      align-items: center;
      background: #b6dfc5;
      padding: 10px 20px;
      border-radius: 12px;
      margin-bottom: 20px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .topbar h1 {
      margin: 0;
      flex-grow: 1;
      color: #2b4c3e;
    }

    .toggle-btn {
      background: transparent;
      border: none;
      font-size: 22px;
      cursor: pointer;
      margin-right: 15px;
    }

    .blog-container {
      background: #ffffff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      max-width: 700px;
      margin: auto;
    }

    .blog-container h2 {
      margin-top: 0;
      color: #388e3c;
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-top: 15px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="file"],
    textarea {
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #b8d8c4;
      border-radius: 8px;
      font-size: 14px;
    }

    textarea {
      resize: vertical;
    }

    button[type="submit"] {
      margin-top: 20px;
      padding: 12px;
      background:rgb(120, 189, 122);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
     
    }

    button[type="submit"]:hover {
      background: #388e3c;
    }

    .error {
      color: red;
      font-weight: bold;
      margin: 10px 0;
      text-align: center;
    }
  </style>
</head>
<body>
 

  <!-- Main Content -->
  <div class="main-content">
    
        
   

    <div class="blog-container">
      <h2>Post a New Blog</h2>

      <!-- Status Message -->
      <?php if (!empty($statusMessage)) echo $statusMessage; ?>

      <form action="post_blog_form.php" method="POST" enctype="multipart/form-data">

        <label for="title">Blog Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image" accept="image/*">

        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="8" required></textarea>

        <button type="submit">Post Blog</button>
      </form>
    </div>
  </div>

  <script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
    }
  </script>
</body>
</html>
