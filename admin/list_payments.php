<?php
include('../includes/connect.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ./admin_login.php");
    exit();
}

// Handle payment deletion
if (isset($_GET['delete_payment'])) {
    $payment_id = mysqli_real_escape_string($con, $_GET['delete_payment']);
    $delete_query = "DELETE FROM `user_payments` WHERE payment_id = ?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $payment_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Payment deleted successfully.";
    } else {
        $error_message = "Error deleting payment: " . mysqli_error($con);
    }
    mysqli_stmt_close($stmt);
}

// Fetch payments
$get_payment_query = "SELECT * FROM `user_payments`";
$get_payment_result = mysqli_query($con, $get_payment_query);

if (!$get_payment_result) {
    die("Query failed: " . mysqli_error($con));
}

$row_count = mysqli_num_rows($get_payment_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payments - Admin Dashboard</title>

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

        .table-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: var(--primary-color);
            color: #fff;
        }

        .table tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
            font-size: 14px;
        }

        .btn-delete {
            background-color: var(--accent-color);
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
            <a href="./insert_product.php"><i class="fas fa-plus-square"></i> Insert Products</a>
            <a href="./view_products.php"><i class="fas fa-eye"></i> View Products</a>
            <a href="./insert_categories.php"><i class="fas fa-tags"></i> Insert Categories</a>
            <a href="./view_categories.php"><i class="fas fa-list-ul"></i> View Categories</a>
            <a href="./insert_brands.php"><i class="fas fa-plus-circle"></i> Insert Brands</a>
            <a href="./view_brands.php"><i class="fas fa-check-circle"></i> View Brands</a>
            <a href="./list_orders.php"><i class="fas fa-shopping-cart"></i> All Orders</a>
            <a href="./list_payments.php" class="active"><i class="fas fa-money-bill-wave"></i> All Payments</a>
            <a href="./list_users.php"><i class="fas fa-users"></i> List Users</a>
            <a href="./admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

        <div class="main-content">
            <h2>View Payments</h2>
            <?php
            if (isset($success_message)) {
                echo "<div class='alert alert-success'>$success_message</div>";
            }
            if (isset($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="table-container">
                <?php if ($row_count == 0): ?>
                    <h2 class="text-center p-2">No payments yet</h2>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Payment No.</th>
                                <th>Order ID</th>
                                <th>Invoice Number</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Payment Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $id_number = 1;
                            while ($row_fetch_payments = mysqli_fetch_assoc($get_payment_result)):
                                $payment_id = $row_fetch_payments['payment_id'];
                                $order_id = $row_fetch_payments['order_id'];
                                $invoice_number = $row_fetch_payments['invoice_number'];
                                $amount = $row_fetch_payments['amount'];
                                $payment_method = $row_fetch_payments['payment_method'];
                                $payment_date = $row_fetch_payments['payment_date'];
                            ?>
                                <tr>
                                    <td><?php echo $id_number; ?></td>
                                    <td><?php echo htmlspecialchars($order_id); ?></td>
                                    <td><?php echo htmlspecialchars($invoice_number); ?></td>
                                    <td><?php echo htmlspecialchars($amount); ?></td>
                                    <td><?php echo htmlspecialchars($payment_method); ?></td>
                                    <td><?php echo htmlspecialchars($payment_date); ?></td>
                                    <td>
                                        <a href="#" onclick="confirmDelete(<?php echo $payment_id; ?>, <?php echo $id_number; ?>)" class="btn btn-delete">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                $id_number++;
                            endwhile;
                            ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(paymentId, paymentNumber) {
        if (confirm(`Are you sure you want to delete Payment No. ${paymentNumber}?`)) {
            window.location.href = `list_payments.php?delete_payment=${paymentId}`;
        }
    }
    </script>
</body>
</html>