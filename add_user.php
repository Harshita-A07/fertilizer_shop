<?php 
include('connect.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$statusMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $frequency = $_POST['purchase_frequency'];
    $avg_order = $_POST['avg_order_value'];
    $loyalty = $_POST['loyalty_points'];

    $check = $conn->query("SELECT * FROM Users WHERE Email = '$email'");
    if ($check->num_rows > 0) {
        $statusMessage = "<p class='error'>User with this email already exists.</p>";
    } else {
        $insert = "INSERT INTO Users (Name, Email, Password, Phone, Purchase_Frequency, Avg_Order_Value, Loyalty_Points)
                   VALUES ('$name', '$email', '$password', '$phone', '$frequency', '$avg_order', '$loyalty')";
        if ($conn->query($insert)) {
            header("Location: manage_users.php");
            exit();
        } else {
            $statusMessage = "<p class='error'>Error adding user. Please try again.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <style>
        body {
            background-color: #e6f4ea;
            font-family: 'Segoe UI', sans-serif;
            color: #333;
        }

        .form-container {
            max-width: 600px;
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

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 5px;
        }

        button {
            margin-top: 20px;
            padding: 12px;
            background-color: #4caf50;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #388e3c;
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
    <h2>Add New User</h2>

    <?php if (!empty($statusMessage)) echo $statusMessage; ?>

    <form method="POST" action="add_user.php">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="purchase_frequency">Purchase Frequency:</label>
        <input type="number" id="purchase_frequency" name="purchase_frequency" step="1" min="0">

        <label for="avg_order_value">Average Order Value:</label>
        <input type="number" id="avg_order_value" name="avg_order_value" step="0.01" min="0">

        <label for="loyalty_points">Loyalty Points:</label>
        <input type="number" id="loyalty_points" name="loyalty_points" step="1" min="0">

        <button type="submit">Add User</button>
    </form>

    <a class="back-link" href="manage_users.php">← Back to Manage Users</a>
</div>

</body>
</html>
