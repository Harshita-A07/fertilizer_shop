<?php
include('connect.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

$user_id = $_GET['id'];
$statusMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_password = $_POST['new_password'];
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $update = "UPDATE Users SET Password = '$hashed_password' WHERE User_ID = $user_id";
    if ($conn->query($update)) {
        header("Location: manage_users.php");
        exit();
    } else {
        $statusMessage = "<p class='error'>Failed to reset password.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            background-color: #e6f4ea;
            font-family: 'Segoe UI', sans-serif;
            color: #333;
        }

        .form-container {
            max-width: 500px;
            margin: 40px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 12px;
            font-weight: bold;
        }

        input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 5px;
        }

        button {
            margin-top: 20px;
            padding: 12px;
            background-color: #ff9800;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #f57c00;
        }

        .error {
            color: red;
            text-align: center;
            font-weight: bold;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #1976d2;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Reset User Password</h2>

    <?php if (!empty($statusMessage)) echo $statusMessage; ?>

    <form method="POST">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>

        <button type="submit">Set New Password</button>
    </form>

    <a class="back-link" href="manage_users.php">← Back to Manage Users</a>
</div>

</body>
</html>
