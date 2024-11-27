<?php
include('../includes/connect.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ./admin_login.php");
    exit();
}

$error_message = $success_message = '';

// Fetch category data
if (isset($_GET['edit_id'])) {
    $edit_id = mysqli_real_escape_string($con, $_GET['edit_id']);
    $get_data_query = "SELECT * FROM `categories` WHERE category_id = ?";
    $stmt = mysqli_prepare($con, $get_data_query);
    mysqli_stmt_bind_param($stmt, "i", $edit_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $category = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$category) {
        header("Location: view_categories.php");
        exit();
    }
} else {
    header("Location: view_categories.php");
    exit();
}

// Update category
if (isset($_POST['update_category'])) {
    $category_title = mysqli_real_escape_string($con, $_POST['category_title']);

    if (empty($category_title)) {
        $error_message = "Please fill in the category title.";
    } else {
        $update_query = "UPDATE `categories` SET category_title = ? WHERE category_id = ?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "si", $category_title, $edit_id);

        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Category updated successfully.";
        } else {
            $error_message = "Error updating category: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Admin Dashboard</title>

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

        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-submit {
            background-color: var(--primary-color);
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #2980b9;
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
            <div class="form-container">
                <h2>Edit Category</h2>
                <?php
                if ($error_message) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                if ($success_message) {
                    echo "<div class='alert alert-success'>$success_message</div>";
                }
                ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="category_title">Category Title</label>
                        <input type="text" id="category_title" name="category_title" value="<?php echo htmlspecialchars($category['category_title']); ?>" required>
                    </div>
                    <button type="submit" name="update_category" class="btn-submit">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>