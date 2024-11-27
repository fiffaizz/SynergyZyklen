<?php
session_start();
include("../includes/connect.php");
include("../functions/common_functions.php");

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('location:user_login.php');
    exit();
}

$username = $_SESSION['username'];

// Fetch user data
$user_query = "SELECT * FROM `user_table` WHERE username = '$username'";
$user_result = mysqli_query($con, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Fetch pending orders
$pending_orders_query = "SELECT * FROM `user_orders` WHERE user_id = '{$user_data['user_id']}' AND payment_status = 'pending' ORDER BY order_date DESC";
$pending_orders_result = mysqli_query($con, $pending_orders_query);

// Fetch all orders
$all_orders_query = "SELECT * FROM `user_orders` WHERE user_id = '{$user_data['user_id']}' ORDER BY order_date DESC";
$all_orders_result = mysqli_query($con, $all_orders_query);

// Handle form submission for account update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    $new_username = mysqli_real_escape_string($con, $_POST['username']);
    $new_email = mysqli_real_escape_string($con, $_POST['email']);
    $new_address = mysqli_real_escape_string($con, $_POST['address']);
    $new_mobile = mysqli_real_escape_string($con, $_POST['phone_number']);
    
    $update_query = "UPDATE `user_table` SET username = '$new_username', user_email = '$new_email', user_address = '$new_address', user_mobile = '$new_mobile' WHERE user_id = '{$user_data['user_id']}'";
    if (mysqli_query($con, $update_query)) {
        $_SESSION['username'] = $new_username;
        $success_message = "Account updated successfully!";
    } else {
        $error_message = "Error updating account. Please try again.";
    }
}

// Handle account deletion
if (isset($_GET['delete_account'])) {
    $delete_query = "DELETE FROM `user_table` WHERE user_id = '{$user_data['user_id']}'";
    if (mysqli_query($con, $delete_query)) {
        session_destroy();
        header('location:user_login.php');
        exit();
    } else {
        $error_message = "Error deleting account. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($username); ?>'s Profile - Synergy Zyklen</title>

    <link rel="icon" type="image/x-icon" href="../assets/images/Synergy-Zyklen-Logo.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/Synergy-Zyklen-Logo.jpg">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
<link rel="stylesheet" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>
<body class="bg-gray-100">
<!-- Start NavBar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.php">Synergy Zyklen</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"  aria-current="page" href="profile.php">My Account</a>
                    </li>
                </ul>
                <form class="d-flex" action="../search_product.php">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../cart.php"><svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 27C11.5523 27 12 26.5523 12 26C12 25.4477 11.5523 25 11 25C10.4477 25 10 25.4477 10 26C10 26.5523 10.4477 27 11 27Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M25 27C25.5523 27 26 26.5523 26 26C26 25.4477 25.5523 25 25 25C24.4477 25 24 25.4477 24 26C24 26.5523 24.4477 27 25 27Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M3 5H7L10 22H26" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M10 16.6667H25.59C25.7056 16.6667 25.8177 16.6267 25.9072 16.5535C25.9966 16.4802 26.0579 16.3782 26.0806 16.2648L27.8806 7.26479C27.8951 7.19222 27.8934 7.11733 27.8755 7.04552C27.8575 6.97371 27.8239 6.90678 27.7769 6.84956C27.73 6.79234 27.6709 6.74625 27.604 6.71462C27.5371 6.68299 27.464 6.66661 27.39 6.66666H8" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <sup>
                                <?php
                                cart_item();
                                ?>
                            </sup>
                            <span class="d-none">
                                Total Price is: 
                                <?php
                                total_cart_price();
                                ?>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" class="d-flex align-items-center gap-1" href="profile.php">
                            <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24 27V24.3333C24 22.9188 23.5224 21.5623 22.6722 20.5621C21.8221 19.5619 20.669 19 19.4667 19H11.5333C10.331 19 9.17795 19.5619 8.32778 20.5621C7.47762 21.5623 7 22.9188 7 24.3333V27" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16.5 14C18.9853 14 21 11.9853 21 9.5C21 7.01472 18.9853 5 16.5 5C14.0147 5 12 7.01472 12 9.5C12 11.9853 14.0147 14 16.5 14Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <?php
                                if(!isset($_SESSION['username'])){
                                    echo "<span>
                                    Welcome guest
                                </span>";
                            }else{
                                    echo "<span>
                                    Welcome ".$_SESSION['username']. "</span>";
                                }
                                ?>
                        </a>
                    </li>
                    <?php
                    if(!isset($_SESSION['username'])){
                        echo "<li class='nav-item'>
                        <a class='nav-link' href='./users_area/user_login.php'>
                            Login
                        </a>
                    </li>";
                }else{
                        echo "<li class='nav-item'>
                        <a class='nav-link' href='./logout.php'>
                            Logout
                        </a>
                    </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End NavBar -->
     
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">My Profile</h1>
        <div class="flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-1/4 bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-col items-center mb-6">
                    <img src="./user_images/<?php echo htmlspecialchars($user_data['user_image']); ?>" alt="<?php echo htmlspecialchars($username); ?>'s profile picture" class="w-24 h-24 rounded-full object-cover mb-2">
                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($username); ?></h2>
                </div>
                <nav>
                    <ul class="space-y-2">
                        <li><a href="#" class="block py-2 px-4 rounded hover:bg-gray-200" onclick="showSection('pending_orders')">Pending Orders</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded hover:bg-gray-200" onclick="showSection('edit_account')">Edit Account</a></li>
                        <li><a href="#" class="block py-2 px-4 rounded hover:bg-gray-200" onclick="showSection('my_orders')">My Orders</a></li>
                        <li><a href="?delete_account" class="block py-2 px-4 rounded hover:bg-gray-200 text-red-600" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">Delete Account</a></li>
                    </ul>
                </nav>
                <a href="logout.php" class="block mt-4 py-2 px-4 bg-gray-200 text-center rounded hover:bg-gray-300">Logout</a>
            </div>
            <div class="w-full md:w-3/4 bg-white rounded-lg shadow-md p-6">
                <?php if (isset($success_message)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if (isset($error_message)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <section id="pending_orders" class="mb-8 hidden">
    <h3 class="text-lg font-semibold mb-4">Pending Orders</h3>
    <?php if (mysqli_num_rows($pending_orders_result) > 0): ?>
        <div class="space-y-4">
            <?php while ($order = mysqli_fetch_assoc($pending_orders_result)): ?>
                <div class="border rounded-lg p-4">
                    <h4 class="font-semibold">Order #<?php echo $order['order_id']; ?></h4>
                    <p>Placed on: <?php echo $order['order_date']; ?></p>
                    <p>Total: RM<?php echo number_format($order['amount_due'], 2); ?></p>
                    <p>Status: <?php echo ucfirst($order['payment_status']); ?></p>
                    <a href="confirm_payment.php?order_id=<?php echo $order['order_id']; ?>" class="mt-2 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Update Payment
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No pending orders.</p>
    <?php endif; ?>
</section>
                
                <section id="edit_account" class="mb-8 hidden">
                    <h3 class="text-lg font-semibold mb-4">Edit Account</h3>
                    <form action="" method="post" class="space-y-4">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['user_email']); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user_data['user_address']); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">phone number</label>
                            <input type="text" id="phone number" name="phone number" value="<?php echo htmlspecialchars($user_data['user_mobile']); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <button type="submit" name="update_account" class="py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700">Save Changes</button>
                    </form>
                </section>
                
                <section id="my_orders" class="mb-8 hidden">
                    <h3 class="text-lg font-semibold mb-4">My Orders</h3>
                    <?php if (mysqli_num_rows($all_orders_result) > 0): ?>
                        <div class="space-y-4">
                            <?php while ($order = mysqli_fetch_assoc($all_orders_result)): ?>
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-semibold">Order #<?php echo $order['order_id']; ?></h4>
                                    <p>Placed on: <?php echo $order['order_date']; ?></p>
                                    <p>Total: RM<?php echo number_format($order['amount_due'], 2); ?></p>
                                    <p>Payment Status: <?php echo ucfirst($order['payment_status']); ?></p>
                                    <p>Order Status: <?php echo ucfirst($order['order_status']); ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p>No orders found.</p>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('section').forEach(section => {
                section.classList.add('hidden');
            });

            // Show the selected section
            document.getElementById(sectionId).classList.remove('hidden');
        }

        // Show pending orders by default
        showSection('pending_orders');

src="../assets/js/bootstrap.bundle.js"
    </script>
</body>
</html>