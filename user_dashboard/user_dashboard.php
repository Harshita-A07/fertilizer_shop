<?php
session_start();
include('../connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
// ✅ Add this line:
$user_id = $_SESSION['user_id'];

// Fetch data
$suggestions = $conn->query("SELECT * FROM Products ORDER BY RAND() LIMIT 4");
$products = $conn->query("SELECT * FROM Products");
$blogs = $conn->query("SELECT * FROM blogs ORDER BY Date_Posted DESC LIMIT 3");

// Fetch data
$suggestions = $conn->query("SELECT * FROM Products ORDER BY RAND() LIMIT 4");
$products = $conn->query("SELECT * FROM Products");
$blogs = $conn->query("SELECT * FROM blogs ORDER BY Date_Posted DESC LIMIT 3");

// Handle cart display
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f9f9f9; display: flex; }
        .sidebar {
            width: 250px; background-color: #2c4d4d; color: white; height: 100vh; position: fixed; top: 0; left: 0; padding-top: 30px;
        }
        .sidebar h2 { text-align: center; margin-bottom: 30px; }
        .sidebar a {
            display: block; padding: 15px 30px; color: white; text-decoration: none; font-size: 18px;
        }
        .sidebar a:hover, .sidebar a.active { background-color: #3e6e6e; }
        .main { margin-left: 250px; padding: 30px; width: calc(100% - 250px); }
        .section { display: none; }
        .section.active { display: block; }
        .products, .blogs {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;
        }
        .card {
            background: white; padding: 15px; border-radius: 10px; border: 1px solid #ccc; text-align: center; box-shadow: 2px 2px 5px rgba(0,0,0,0.05);
        }
        .card img { max-width: 100%; border-radius: 8px; }
        .card h3 { color: #2c4d4d; }
        .btn {
            padding: 8px 12px; background: #2c4d4d; color: white; border: none; border-radius: 5px; margin-top: 10px; cursor: pointer;
        }
        .welcome-box {
            background: #e0f7f1; padding: 20px; border-radius: 10px; margin-bottom: 30px;
        }
        .welcome-box h1 { margin: 0; color: #2c4d4d; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    </style>
</head>
<body>

    <!-- Sidebar -->   
    <div class="sidebar">
        <h2>🌿 Fertilizer Shop</h2>
        <a href="#" class="tab-link active" data-tab="dashboard"><i class='bx bx-home'></i> Dashboard</a>
        <a href="#" class="tab-link" data-tab="products"><i class='bx bx-box'></i> All Products</a>
        <a href="#" class="tab-link" data-tab="blogs"><i class='bx bx-news'></i> Owner's Blogs</a>
        <a href="#" class="tab-link" data-tab="cart"><i class='bx bx-cart'></i> My Cart</a>
        <a href="logout_userdashboard.php"><i class='bx bx-log-out'></i> Logout</a>

    </div>

    <!-- Main Content -->
    <div class="main">
        <!-- Dashboard -->
        <div id="dashboard" class="section active">
            <div class="welcome-box">
                <h1>Welcome, <?= $_SESSION['username'] ?>! 🌱</h1>
                <p>Grow your garden, nourish your soil – find the best fertilizers here!</p>
            </div>
            <h2>🌟 Product Suggestions for You</h2>
            <div class="products">
                <?php while($row = $suggestions->fetch_assoc()) { ?>
                    <div class="card">
                        <h3><?= $row['Name'] ?></h3>
                        <p><?= $row['Description'] ?></p>
                        <p><strong>₹<?= $row['Price'] ?></strong></p>
                        <form method="POST" action="add_to_cart.php">
                            <input type="hidden" name="product_id" value="<?= $row['Product_ID'] ?>">
                            <button type="submit" class="btn">Add to Cart</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Products with Search -->
<div id="products" class="section">
    <h2>📦 All Products</h2>

    <!-- Search bar -->
    <form method="GET" style="margin-bottom: 20px;">
        <input type="hidden" name="tab" value="products">
        <input type="text" name="search" placeholder="Search by name or type..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" style="padding: 8px; width: 250px; border-radius: 5px; border: 1px solid #ccc;">
        <button type="submit" class="btn">Search</button>
    </form>

    <div class="products">
        <?php
        $searchTerm = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
        $query = "SELECT * FROM Products";
        if (!empty($searchTerm)) {
            $query .= " WHERE Name LIKE '%$searchTerm%' OR Category LIKE '%$searchTerm%'";
        }
        $result = $conn->query($query);
        ?>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <a href="product_detail.php?product_id=<?= $row['Product_ID'] ?>" style="text-decoration: none; color: inherit;">
    <div class="card">
        <?php if (!empty($row['Image_Path'])): ?>
            <img src="../<?= $row['Image_Path'] ?>" alt="<?= $row['Name'] ?>" style="width:100%; height:180px; object-fit:cover; border-radius:8px;">
        <?php endif; ?>
        <h3><?= $row['Name'] ?></h3>
        <p><strong>₹<?= $row['Price'] ?></strong></p>
    </div>
</a>

            <?php } ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>

        <!-- Blogs -->
        <div id="blogs" class="section">
            <h2>📝 Owner's Blogs</h2>
            <div class="blogs">
                <?php while($blog = $blogs->fetch_assoc()) { ?>
                    <div class="card">
                        <h3><?= $blog['Title'] ?></h3>
                        <?php if ($blog['Image_Path']) { ?>
                            <img src="../<?= $blog['Image_Path'] ?>" alt="Blog Image">
                        <?php } ?>
                        <p><?= substr($blog['Content'], 0, 100) ?>...</p>
                        <small><em>Posted on <?= date('d M Y', strtotime($blog['Date_Posted'])) ?></em></small>
                    </div>
                <?php } ?>
            </div>
        </div>
<!-- My Cart Section -->
<div id="cart" class="section">
    <h2>🛒 Items in Your Cart</h2>
    <?php
    $cartQuery = "
        SELECT cart.Product_ID, products.Name, products.Price, cart.Quantity, (products.Price * cart.Quantity) AS Total
        FROM cart
        JOIN products ON cart.Product_ID = products.Product_ID
        WHERE cart.User_ID = ?
    ";
    $stmt = $conn->prepare($cartQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <form method="POST" action="update_cart.php">
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php
            $total_cart_price = 0;
            while ($row = $result->fetch_assoc()) {
                $total_cart_price += $row['Total'];
                echo "<tr>
                        <td>{$row['Name']}</td>
                        <td>₹{$row['Price']}</td>
                        <td><input type='number' name='quantities[{$row['Product_ID']}]' value='{$row['Quantity']}' min='1'></td>
                        <td>₹{$row['Total']}</td>
                        <td><a href='remove_item.php?product_id={$row['Product_ID']}' style='color:red;'>Remove</a></td>
                    </tr>";
            }
            ?>
        </table>
        <p class="total">Cart Total: ₹<?= $total_cart_price ?></p>
        <div style="margin-top: 20px;">
            <button type="submit" class="btn">Update Quantities</button>
            <a href="checkout_address.php" class="btn">Proceed to Checkout</a>
        </div>
    </form>
</div>

        
    </div>

    <script>
        // Sidebar tab switching
        const links = document.querySelectorAll('.tab-link');
        const sections = document.querySelectorAll('.section');
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                links.forEach(l => l.classList.remove('active'));
                sections.forEach(sec => sec.classList.remove('active'));
                this.classList.add('active');
                document.getElementById(this.dataset.tab).classList.add('active');
            });
        });

        // Auto open cart if redirected with ?tab=cart
        const urlParams = new URLSearchParams(window.location.search);
        const defaultTab = urlParams.get('tab');
        if (defaultTab) {
            document.querySelectorAll('.tab-link').forEach(link => {
                if (link.dataset.tab === defaultTab) {
                    link.click();
                }
            });
        }
    </script>

</body>
</html>