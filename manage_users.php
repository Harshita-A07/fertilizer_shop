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
            font-family: 'Segoe UI', sans-serif;
            background-color: #e6f4ea;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }

        .status-message {
            text-align: center;
            padding: 12px;
            font-weight: bold;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .success {
            color: #2e7d32;
            background-color: #d0f0c0;
            border: 1px solid #81c784;
        }

        .error {
            color: #c62828;
            background-color: #fddede;
            border: 1px solid #ef5350;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .top-bar input[type="text"] {
            padding: 8px;
            width: 300px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .top-bar a {
            padding: 10px 15px;
            background: #4caf50;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #c8e6c9;
            cursor: pointer;
        }

        tr:hover {
            background-color: #f1f8e9;
        }

        .btn {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }

        .edit-btn { background-color: #1976d2; }
        .reset-btn { background-color: #ff9800; }
        .delete-btn { background-color: #e53935; }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Users</h2>

    <!-- ✅ Status Messages -->
    <?php if (isset($_GET['status'])): ?>
        <div class="status-message 
            <?= $_GET['status'] === 'deleted' ? 'success' : ($_GET['status'] === 'error' ? 'error' : '') ?>">
            <?php
                if ($_GET['status'] === 'deleted') echo "✅ User deleted successfully.";
                elseif ($_GET['status'] === 'error') echo "❌ Error processing your request.";
                elseif ($_GET['status'] === 'updated') echo "✅ User updated successfully.";
                elseif ($_GET['status'] === 'added') echo "✅ User added successfully.";
            ?>
        </div>
    <?php endif; ?>

    <div class="top-bar">
        <input type="text" id="searchInput" placeholder="Search by name, email, or phone">
        <a href="add_user.php">+ Add New User</a>
    </div>

    <table id="usersTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)">User ID</th>
                <th onclick="sortTable(1)">Name</th>
                <th onclick="sortTable(2)">Email</th>
                <th>Phone</th>
                <th>Purchase Frequency</th>
                <th>Avg Order Value</th>
                <th>Loyalty Points</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['User_ID'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['Email'] ?></td>
                <td><?= $row['Phone'] ?></td>
                <td><?= $row['Purchase_Frequency'] ?></td>
                <td><?= $row['Avg_Order_Value'] ?></td>
                <td><?= $row['Loyalty_Points'] ?></td>
                <td>
                    <a class="btn edit-btn" href="edit_user.php?id=<?= $row['User_ID'] ?>">Edit</a>
                    <a class="btn reset-btn" href="reset_password.php?id=<?= $row['User_ID'] ?>">Reset</a>
                    <a class="btn delete-btn" href="delete_user.php?id=<?= $row['User_ID'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
// Search filter
document.getElementById("searchInput").addEventListener("keyup", function () {
    let input = this.value.toLowerCase();
    let rows = document.querySelectorAll("#usersTable tbody tr");
    rows.forEach(row => {
        row.style.display = Array.from(row.cells).some(cell =>
            cell.textContent.toLowerCase().includes(input)
        ) ? "" : "none";
    });
});

// Sort table
function sortTable(colIndex) {
    const table = document.getElementById("usersTable");
    let switching = true;
    let shouldSwitch;
    let direction = "asc";
    let switchCount = 0;

    while (switching) {
        switching = false;
        const rows = table.rows;

        for (let i = 1; i < rows.length - 1; i++) {
            shouldSwitch = false;
            const x = rows[i].getElementsByTagName("TD")[colIndex];
            const y = rows[i + 1].getElementsByTagName("TD")[colIndex];

            if ((direction === "asc" && x.textContent.toLowerCase() > y.textContent.toLowerCase()) ||
                (direction === "desc" && x.textContent.toLowerCase() < y.textContent.toLowerCase())) {
                shouldSwitch = true;
                break;
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchCount++;
        } else {
            if (switchCount === 0 && direction === "asc") {
                direction = "desc";
                switching = true;
            }
        }
    }
}
</script>

</body>
</html>
