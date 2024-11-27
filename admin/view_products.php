<?php
include("../includes/connect.php");
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ./admin_login.php");
    exit();
}

// Handle product deletion
if (isset($_GET['delete_product'])) {
    $product_id = mysqli_real_escape_string($con, $_GET['delete_product']);
    $delete_query = "DELETE FROM `products` WHERE product_id = ?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Product deleted successfully.";
    } else {
        $error_message = "Error deleting product: " . mysqli_error($con);
    }
    mysqli_stmt_close($stmt);
}

// Fetch products
$get_product_query = "SELECT p.*, COALESCE(SUM(op.quantity), 0) as total_sold 
                      FROM `products` p 
                      LEFT JOIN `orders_pending` op ON p.product_id = op.product_id 
                      GROUP BY p.product_id";
$get_product_result = mysqli_query($con, $get_product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products - Admin Dashboard</title>

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

        .product-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .product-table th, .product-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .product-table th {
            background-color: var(--primary-color);
            color: #fff;
        }

        .product-table tr:hover {
            background-color: #f5f5f5;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        .action-buttons a {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            text-decoration: none;
            color: #fff;
            margin-right: 5px;
        }

        .edit-btn {
            background-color: #3498db;
        }

        .delete-btn {
            background-color: #e74c3c;
        }

        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .product-table {
                font-size: 14px;
            }

            .product-image {
                width: 60px;
                height: 60px;
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
            <h2>View Products</h2>
            <?php
            if (isset($success_message)) {
                echo "<div class='alert alert-success'>$success_message</div>";
            }
            if (isset($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Total Sold</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id_number = 1;
                    while ($row = mysqli_fetch_assoc($get_product_result)) {
                        echo "<tr>
                            <td>{$id_number}</td>
                            <td>{$row['product_title']}</td>
                            <td><img src='./product_images/{$row['product_image_one']}' alt='{$row['product_title']}' class='product-image'/></td>
                            <td>RM {$row['product_price']}</td>
                            <td>{$row['total_sold']}</td>
                            <td>{$row['status']}</td>
                            <td class='action-buttons'>
                                <a href='edit_product.php?edit_id={$row['product_id']}' class='edit-btn'><i class='fas fa-edit'></i></a>
                                <a href='#' onclick='confirmDelete({$row['product_id']})' class='delete-btn'><i class='fas fa-trash-alt'></i></a>
                            </td>
                        </tr>";
                        $id_number++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function confirmDelete(productId) {
        if (confirm('Are you sure you want to delete this product?')) {
            window.location.href = 'view_products.php?delete_product=' + productId;
        }
    }
    </script>
</body>
</html>