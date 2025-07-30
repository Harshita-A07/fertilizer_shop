<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../connect.php');

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Check if email already exists
        $check_email = "SELECT * FROM users WHERE Email = '$email'";
        $result = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Email already registered. Please login or use another email.');</script>";
        } else {
            // Insert new user
            $query = "INSERT INTO users (Name, Email, Phone, Password) 
                      VALUES ('$name', '$email', '$phone', '$password')";

            if (mysqli_query($conn, $query)) {
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                $_SESSION['username'] = $name;
                header("Location: ../user_dashboard/user_dashboard.php");
                exit;
            } else {
                echo "<script>alert('Signup Failed! Please try again.');</script>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Signup - AgriShop</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to left, #d8f0ce, #92d5a2ff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Roboto', sans-serif;
      margin: 0;
    }

    .signup-box {
      background: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      width: 400px;
    }

    h2 {
      text-align: center;
      color: #2e7d32;
      margin-bottom: 30px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #46855f;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 20px;
    }

    button:hover {
      background-color: #1b5e20;
    }

    .login-link {
      text-align: center;
      margin-top: 15px;
    }

    .login-link a {
      color: #2e7d32;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <form class="signup-box" method="POST">
    <h2>Create Account</h2>
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="tel" name="phone" placeholder="Phone Number" required>
    <input type="password" name="password" placeholder="Create Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    <button type="submit">Sign Up</button>
    <div class="login-link">
      Already have an account? <a href="login.html">Login here</a>
    </div>
  </form>
</body>
</html>
