<?php
include('../includes/connect.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ./admin_login.php");
    exit();
}

if(isset($_POST['insert_product'])){
    $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
    $product_description = mysqli_real_escape_string($con, $_POST['product_description']);
    $product_keywords = mysqli_real_escape_string($con, $_POST['product_keywords']);
    $product_category = mysqli_real_escape_string($con, $_POST['product_category']);
    $product_brand = mysqli_real_escape_string($con, $_POST['product_brand']);
    $product_price = mysqli_real_escape_string($con, $_POST['product_price']);
    $product_status = 'true';

    // File upload handling
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $max_file_size = 5 * 1024 * 1024; // 5MB
    $upload_dir = "./product_images/";
    $product_images = [];

    for ($i = 1; $i <= 3; $i++) {
        $file_name = $_FILES["product_image_$i"]['name'];
        $file_tmp = $_FILES["product_image_$i"]['tmp_name'];
        $file_size = $_FILES["product_image_$i"]['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_extensions)) {
            die("Error: Only JPG, JPEG, PNG, and GIF files are allowed.");
        }

        if ($file_size > $max_file_size) {
            die("Error: File size is larger than the allowed limit.");
        }

        $new_file_name = uniqid("product_", true) . "." . $file_ext;
        $upload_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            $product_images[] = $new_file_name;
        } else {
            die("Error: There was an error uploading your file.");
        }
    }

    if(empty($product_title) || empty($product_description) || empty($product_keywords) || 
       empty($product_category) || empty($product_brand) || empty($product_price) || 
       count($product_images) !== 3) {
        $error_message = "All fields are required.";
    } else {
        $insert_query = "INSERT INTO `products` (product_title, product_description, product_keywords, 
                         category_id, brand_id, product_image_one, product_image_two, product_image_three, 
                         product_price, date, status) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
        
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "sssiisssds", $product_title, $product_description, $product_keywords, 
                               $product_category, $product_brand, $product_images[0], $product_images[1], 
                               $product_images[2], $product_price, $product_status);
        
        if(mysqli_stmt_execute($stmt)){
            $success_message = "Product Inserted Successfully";
        } else {
            $error_message = "Error: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    }
}

// Fetch categories and brands
$categories = mysqli_query($con, 'SELECT * FROM `categories`');
$brands = mysqli_query($con, 'SELECT * FROM `brands`');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products - Admin Dashboard</title>

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
            max-width: 800px;
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

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input[type="file"] {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
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
                <h2>Insert Product</h2>
                <?php
                if (isset($success_message)) {
                    echo "<div class='alert alert-success'>$success_message</div>";
                }
                if (isset($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="product_title">Product Title</label>
                        <input type="text" id="product_title" name="product_title" required>
                    </div>
                    <div class="form-group">
                        <label for="product_description">Product Description</label>
                        <textarea id="product_description" name="product_description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="product_keywords">Product Keywords</label>
                        <input type="text" id="product_keywords" name="product_keywords" required>
                    </div>
                    <div class="form-group">
                        <label for="product_category">Product Category</label>
                        <select id="product_category" name="product_category" required>
                            <option value="">Select a Category</option>
                            <?php
                            while ($category = mysqli_fetch_assoc($categories)) {
                                echo "<option value='{$category['category_id']}'>{$category['category_title']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_brand">Product Brand</label>
                        <select id="product_brand" name="product_brand" required>
                            <option value="">Select a Brand</option>
                            <?php
                            while ($brand = mysqli_fetch_assoc($brands)) {
                                echo "<option value='{$brand['brand_id']}'>{$brand['brand_title']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_image_1">Product Image 1</label>
                        <input type="file" id="product_image_1" name="product_image_1" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="product_image_2">Product Image 2</label>
                        <input type="file" id="product_image_2" name="product_image_2" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="product_image_3">Product Image 3</label>
                        <input type="file" id="product_image_3" name="product_image_3" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="product_price">Product Price</label>
                        <input type="number" id="product_price" name="product_price" step="0.01" required>
                    </div>
                    <button type="submit" name="insert_product" class="btn-submit">Insert Product</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>