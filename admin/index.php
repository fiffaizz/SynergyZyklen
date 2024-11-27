<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: ./admin_login.php");
    exit();
}

// Fetch admin details
$admin_name = $_SESSION['admin_username'];
$get_admin_data = "SELECT * FROM `admin_table` WHERE admin_name = '$admin_name'";
$get_admin_result = mysqli_query($con, $get_admin_data);

if ($get_admin_result && mysqli_num_rows($get_admin_result) > 0) {
    $row_fetch_admin_data = mysqli_fetch_assoc($get_admin_result);
    $admin_name = htmlspecialchars($row_fetch_admin_data['admin_name']);
    $admin_image = htmlspecialchars($row_fetch_admin_data['admin_image']);
    $admin_email = htmlspecialchars($row_fetch_admin_data['admin_email']);
} else {
    header("Location: ./admin_login.php");
    exit();
}

// Fetch dashboard summary data
$product_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM products"))['count'];
$customer_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM user_table"))['count'];
$category_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM categories"))['count'];
$order_count = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM user_orders"))['count'];

// Fetch latest 5 orders
$get_orders = "
    SELECT 
        uo.order_id,
        uo.invoice_number,
        uo.total_products AS product_qty,
        uo.amount_due,
        uo.order_date,
        uo.payment_status,
        uo.order_status,
        ut.user_email AS customer_email
    FROM 
        user_orders uo
    JOIN 
        user_table ut ON uo.user_id = ut.user_id
    ORDER BY 
        uo.order_id DESC
    LIMIT 5";
$get_orders_result = mysqli_query($con, $get_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="icon" type="image/x-icon" href="../assets/images/Synergy-Zyklen-Logo.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/Synergy-Zyklen-Logo.jpg">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --text-color: #333;
            --bg-color: #f4f4f4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--bg-color);
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--secondary-color);
            color: #fff;
            padding: 20px;
        }

        .sidebar h3 {
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .dashboard-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .summary-card i {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .order-table {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: var(--primary-color);
            color: #fff;
        }

        .profile-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .profile-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .main-content {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h3>Admin Panel</h3>
            <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="./insert_product.php" class="active"><i class="fas fa-plus-square"></i> Insert Products</a>
            <a href="./view_products.php"><i class="fas fa-eye"></i> View Products</a>
            <a href="./insert_categories.php"><i class="fas fa-tags"></i> Insert Categories</a>
            <a href="./view_categories.php"><i class="fas fa-list-ul"></i> View Categories</a>
            <a href="./insert_brands.php"><i class="fas fa-plus-circle"></i> Insert Brands</a>
            <a href="./view_brands.php"><i class="fas fa-check-circle"></i> View Brands</a>
            <a href="./list_orders.php"><i class="fas fa-shopping-cart"></i> All Orders</a>
            <a href="./list_payments.php"><i class="fas fa-money-bill-wave"></i> All Payments</a>
            <a href="./list_users.php"><i class="fas fa-users"></i> List Users</a>
            <a href="./admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

        <div class="main-content">
            <h2>Welcome, <?php echo $admin_name; ?>!</h2>

            <div class="dashboard-summary">
                <div class="summary-card">
                    <i class="fas fa-box"></i>
                    <h3><?php echo $product_count; ?></h3>
                    <p>Products</p>
                </div>
                <div class="summary-card">
                    <i class="fas fa-users"></i>
                    <h3><?php echo $customer_count; ?></h3>
                    <p>Customers</p>
                </div>
                <div class="summary-card">
                    <i class="fas fa-tags"></i>
                    <h3><?php echo $category_count; ?></h3>
                    <p>Categories</p>
                </div>
                <div class="summary-card">
                    <i class="fas fa-shopping-cart"></i>
                    <h3><?php echo $order_count; ?></h3>
                    <p>Orders</p>
                </div>
            </div>

            <div class="order-table">
                <h3>Recent Orders</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Email</th>
                            <th>Invoice Number</th>
                            <th>Product Quantity</th>
                            <th>Amount Due</th>
                            <th>Order Date</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($get_orders_result && mysqli_num_rows($get_orders_result) > 0) {
                            while ($order = mysqli_fetch_assoc($get_orders_result)) {
                                echo "<tr>
                                    <td>{$order['order_id']}</td>
                                    <td>{$order['customer_email']}</td>
                                    <td>{$order['invoice_number']}</td>
                                    <td>{$order['product_qty']}</td>
                                    <td>RM{$order['amount_due']}</td>
                                    <td>{$order['order_date']}</td>
                                    <td>{$order['payment_status']}</td>
                                    <td>{$order['order_status']}</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No recent orders found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="profile-card">
                <img src="./admin_images/<?php echo $admin_image; ?>" alt="Admin Profile Picture">
                <h3><?php echo $admin_name; ?></h3>
                <p><strong>Email:</strong> <?php echo $admin_email; ?></p>
            </div>
        </div>
    </div>
</body>
</html>