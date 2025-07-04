<?php
include('connect.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$result = $conn->query("SELECT * FROM Users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e6f4ea; /* pastel green */
            color: #333;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #2e7d32;
        }

        .table-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color:rgb(163, 216, 171);
            color: #004d40;
        }

        tr:hover {
            background-color: #f1f8e9;
        }
    </style>
</head>
<body>

    <div class="table-container">
        <h2>Registered Users</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['User_ID'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['Email'] ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
