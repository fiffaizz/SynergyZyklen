<?php
include('./includes/connect.php');
include('./functions/common_functions.php');
session_start();

// Function to update cart
function updateCart($con, $getIpAddress) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'qty_') === 0) {
            $product_id = substr($key, 4);
            $quantity = intval($value);
            if ($quantity > 0) {
                $update_cart_query = "UPDATE `card_details` SET quantity = $quantity WHERE ip_address='$getIpAddress' AND product_id=$product_id";
                mysqli_query($con, $update_cart_query);
            }
        }
    }
}

// Function to remove item from cart
function removeItem($con, $getIpAddress, $product_id) {
    $delete_query = "DELETE FROM `card_details` WHERE product_id=$product_id AND ip_address='$getIpAddress'";
    mysqli_query($con, $delete_query);
}

$getIpAddress = getIPAddress();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cart'])) {
        updateCart($con, $getIpAddress);
    } elseif (isset($_POST['remove_item'])) {
        $product_id = $_POST['remove_item'];
        removeItem($con, $getIpAddress, $product_id);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Synergy Zyklen</title>

    <link rel="icon" type="image/x-icon" href="./assets/images/Synergy-Zyklen-Logo.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/images/Synergy-Zyklen-Logo.jpg">
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/bootstrap.css" />
    <link rel="stylesheet" href="./assets/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
     <!-- Start NavBar -->
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Synergy Zyklen</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./about.php">About</a>
                    </li>
                    <?php
                        if(isset($_SESSION['username'])){                            
                            echo "
                            <li class='nav-item'>
                            <a class='nav-link' href='./users_area/profile.php'>My Account</a>
                        </li>";
                        }
                        else{
                            echo "
                            <li class='nav-item'>
                            <a class='nav-link' href='./users_area/user_registration.php'>Register</a>
                        </li>";
                        }
                    ?>
                </ul>
                <form class="d-flex">
                <form class="d-flex" action="search_product.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                    <input type="submit" value="Search" class="btn btn-outline-primary" name="search_data_product">
                </form>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="./cart.php"><svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        <a class="nav-link" class="d-flex align-items-center gap-1" href="./users_area/profile.php">
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
                        <a class='nav-link' href='./users_area/logout.php'>
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
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-1">Shopping Cart</h1>
        <p class="text-sm text-gray-500 mb-8">Shipping charges and discount codes are confirmed at checkout.</p>
        
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <h2 class="font-medium mb-4">Your order</h2>
                
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <?php
                    $total_price = 0;
                    $cart_query = "SELECT * FROM `card_details` WHERE ip_address='$getIpAddress'";
                    $cart_result = mysqli_query($con, $cart_query);
                    $result_count = mysqli_num_rows($cart_result);
                    if ($result_count > 0) {
                        while ($row = mysqli_fetch_array($cart_result)) {
                            $product_id = $row['product_id'];
                            $product_quantity = $row['quantity'];
                            $select_product_query = "SELECT * FROM `products` WHERE product_id=$product_id";
                            $select_product_result = mysqli_query($con, $select_product_query);
                            while ($row_product_price = mysqli_fetch_array($select_product_result)) {
                                $product_price = $row_product_price['product_price'];
                                $product_title = $row_product_price['product_title'];
                                $product_image_one = $row_product_price['product_image_one'];
                                $total_price += $product_price * $product_quantity;
                    ?>
                                <div class="flex gap-4 mb-6">
                                    <div class="w-24 h-24 bg-gray-200 rounded-lg">
                                        <img src="./admin/product_images/<?php echo $product_image_one; ?>" alt="<?php echo $product_title; ?>" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium"><?php echo $product_title; ?></h3>
                                        <p class="text-sm text-gray-500">Shipping: 2-4 weeks</p>
                                        <div class="flex items-center justify-between mt-2">
                                            <div class="flex items-center gap-2">
                                                <button type="button" class="w-8 h-8 flex items-center justify-center border rounded" onclick="updateQuantity(<?php echo $product_id; ?>, -1)">-</button>
                                                <input type="number" id="qty_<?php echo $product_id; ?>" name="qty_<?php echo $product_id; ?>" value="<?php echo $product_quantity; ?>" min="1" class="w-8 text-center">
                                                <button type="button" class="w-8 h-8 flex items-center justify-center border rounded" onclick="updateQuantity(<?php echo $product_id; ?>, 1)">+</button>
                                            </div>
                                            <p class="font-medium">RM<?php echo number_format($product_price, 2); ?></p>
                                        </div>
                                        <button type="submit" name="remove_item" value="<?php echo $product_id; ?>" class="mt-2 text-red-600">Remove</button>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    } else {
                        echo "<p>Your cart is empty</p>";
                    }
                    ?>

                    <div class="mt-6 flex gap-4">
                        <input type="submit" value="Update Cart" name="update_cart" class="px-4 py-2 bg-gray-800 text-white rounded">
                    </div>

                    <div class="mt-12">
                        <h2 class="font-medium mb-4">Safe & easy shopping</h2>
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full border flex items-center justify-center">↩</div>
                                <span>Free returns for 30 days</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full border flex items-center justify-center">💳</div>
                                <span>Convenient payment methods</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full border flex items-center justify-center">🚚</div>
                                <span>Deliver to home</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-1">
                <div class="border rounded-lg p-4">
                    <h2 class="font-medium mb-4">Summary</h2>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Items in the Cart</span>
                            <span>RM<?php echo number_format($total_price, 2); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Shipping (estimated)</span>
                            <span>RM10.00</span>
                        </div>
                    </div>
                    <div class="flex justify-between font-medium mb-6">
                        <span>Total</span>
                        <span>RM<?php echo number_format($total_price + 10, 2); ?></span>
                    </div>
                    <a href="./users_area/checkout.php" class="block w-full bg-gray-800 text-white py-3 rounded-lg mb-4 text-center">GO TO CHECKOUT</a>
                </div>
            </div>
        </div>
    </div>

        <!-- Start Footer -->
        <footer class="bg-light py-5 mt-5 border-top">
        <div class="container">

            <!-- Footer Links -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5 class="h6 font-weight-bold mb-3">Need help?</h5>
                    <a href="https://t.me/+RH-IFpecM_s5OGM9" class="btn btn-secondary btn-block">Contact Us</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="h6 font-weight-bold mb-3">Customer Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="./refund.php" class="text-muted small">Returns & Warranty</a></li>
                        <li><a href="./term.php" class="text-muted small">Terms of Service</a></li>
                        <li><a href="./privacy.php" class="text-muted small">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="h6 font-weight-bold mb-3">Corporate Info</h5>
                    <ul class="list-unstyled">
                        <li><a href="./about.php" class="text-muted small">About Us</a></li>
                        <li><a href="./license.php" class="text-muted small">License and System Ownership</a></li>
                        <li><a href="./cookies.php" class="text-muted small">Cookies</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 class="h6 font-weight-bold mb-3">Follow Us</h5>
                    <div class="d-flex justify-content-between">
                        <a href="https://www.instagram.com/synergyzyklen?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="text-muted"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="https://www.facebook.com/profile.php?id=61558674133864" class="text-muted"><i class="fab fa-facebook fa-lg"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <script>
        function updateQuantity(productId, change) {
            const input = document.getElementById('qty_' + productId);
            let newValue = parseInt(input.value) + change;
            if (newValue < 1) newValue = 1;
            input.value = newValue;
        }
    </script>
</body>
</html>