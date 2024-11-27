<?php
// include connect file from DB
// include('./includes/connect.php');

// getting products
function getProduct($numToDisplay = '')
{
    global $con;
    // condition to check isset or not 
    if (!isset($_GET['category']) && !isset($_GET['brand'])) {
        $select_product_query = empty($numToDisplay) 
            ? "SELECT * FROM `products` WHERE status='true' ORDER BY rand()" 
            : "SELECT * FROM `products` WHERE status='true' ORDER BY rand() LIMIT 0,$numToDisplay";
        
        $select_product_result = mysqli_query($con, $select_product_query);
        while ($row = mysqli_fetch_assoc($select_product_result)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_image_one = $row['product_image_one'];
            $product_price = $row['product_price'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];
            echo "
            <div class='col-md-4 mb-2'>
                <div class='one-card'>
                    <div class='photo'>
                        <img src='./admin/product_images/$product_image_one' alt='$product_title'>
                        <button>
                            <a class='text-light' href='products.php?add_to_cart=$product_id'>Add To Cart</a>
                        </button>
                        <button>
                            <a class='text-light' href='product_details.php?product_id=$product_id'>View More</a>
                        </button>
                    </div>
                    <div class='content'>
                        <span class='title fw-bold'>$product_title</span>
                        <div class='desc'>
                            <span>RM$product_price</span>
                        </div>
                    </div>
                </div>
            </div>
            ";
        }
    }
}

// display unique product with category
function filterCategoryProduct()
{
    global $con;
    if (isset($_GET['category'])) {
        $category_id = $_GET['category'];
        $select_product_query = "SELECT * FROM `products` WHERE category_id = $category_id AND status='true'";
        $select_product_result = mysqli_query($con, $select_product_query);
        $num_of_rows = mysqli_num_rows($select_product_result);
        if ($num_of_rows == 0) {
            echo "<h2 class='text-center'>No Stock for this category</h2>";
        }
        while ($row = mysqli_fetch_assoc($select_product_result)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_image_one = $row['product_image_one'];
            $product_price = $row['product_price'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];
            echo "
            <div class='col-md-4 mb-2'>
                <div class='one-card'>
                    <div class='photo'>
                        <img src='./admin/product_images/$product_image_one' alt='$product_title'>
                        <button>
                            <a class='text-light' href='products.php?add_to_cart=$product_id'>Add To Cart</a>
                        </button>
                        <button>
                            <a class='text-light' href='product_details.php?product_id=$product_id'>View More</a>
                        </button>
                    </div>
                    <div class='content'>
                        <span class='title fw-bold'>$product_title</span>
                        <div class='desc'>
                            <span>RM$product_price</span>
                        </div>
                    </div>
                </div>
            </div>
            ";
        }
    }
}

// display unique product with brand 
function filterBrandProduct()
{
    global $con;
    if (isset($_GET['brand'])) {
        $brand_id = $_GET['brand'];
        $select_product_query = "SELECT * FROM `products` WHERE brand_id = $brand_id AND status='true'";
        $select_product_result = mysqli_query($con, $select_product_query);
        $num_of_rows = mysqli_num_rows($select_product_result);
        if ($num_of_rows == 0) {
            echo "<h2 class='text-center'>No Stock for this brand</h2>";
        }
        while ($row = mysqli_fetch_assoc($select_product_result)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_image_one = $row['product_image_one'];
            $product_price = $row['product_price'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];
            echo "
            <div class='col-md-4 mb-2'>
                <div class='one-card'>
                    <div class='photo'>
                        <img src='./admin/product_images/$product_image_one' alt='$product_title'>
                        <button>
                            <a class='text-light' href='products.php?add_to_cart=$product_id'>Add To Cart</a>
                        </button>
                        <button>
                            <a class='text-light' href='product_details.php?product_id=$product_id'>View More</a>
                        </button>
                    </div>
                    <div class='content'>
                        <span class='title fw-bold'>$product_title</span>
                        <div class='desc'>
                            <span>RM$product_price</span>
                        </div>
                    </div>
                </div>
            </div>
            ";
        }
    }
}

// display brands in sidenav 
function getBrands()
{
    global $con;
    $select_brands_query = "SELECT * FROM `brands`";
    $select_brands_result = mysqli_query($con, $select_brands_query);
    while ($brands_row_data = mysqli_fetch_assoc($select_brands_result)) {
        $brand_title = $brands_row_data['brand_title'];
        $brand_id = $brands_row_data['brand_id'];
        echo "
        <li class='nav-item'>
            <a href='products.php?brand=$brand_id' class='nav-link'>
                $brand_title
            </a>
        </li>
    ";
    }
}

// display categories in sidenav 
function getCategories()
{
    global $con;
    $select_category_query = "SELECT * FROM `categories`";
    $select_category_result = mysqli_query($con, $select_category_query);
    while ($categories_row_data = mysqli_fetch_assoc($select_category_result)) {
        $category_title = $categories_row_data['category_title'];
        $category_id = $categories_row_data['category_id'];
        echo "
        <li class='nav-item'>
        <a href='products.php?category=$category_id' class='nav-link'>
            $category_title
        </a>
    </li>
        ";
    }
}

// search product function 
function search_product()
{
    global $con;
    if (isset($_GET['search_data_btn'])) {
        $search_data_value = $_GET['search_data'];
        $search_product_query = "SELECT * FROM `products` WHERE (product_title LIKE '%$search_data_value%' OR product_keywords LIKE '%$search_data_value%') AND status='true'";
        $search_product_result = mysqli_query($con, $search_product_query);
        $num_of_rows = mysqli_num_rows($search_product_result);
        if ($num_of_rows == 0) {
            echo "<h2 class='text-center'>No results match. No product found!</h2>";
        }
        while ($row = mysqli_fetch_assoc($search_product_result)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_image_one = $row['product_image_one'];
            $product_price = $row['product_price'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];
            echo "
            <div class='col-md-4 mb-2'>
                <div class='one-card'>
                    <div class='photo'>
                        <img src='./admin/product_images/$product_image_one' alt='$product_title'>
                        <button>
                            <a class='text-light' href='products.php?add_to_cart=$product_id'>Add To Cart</a>
                        </button>
                        <button>
                            <a class='text-light' href='product_details.php?product_id=$product_id'>View More</a>
                        </button>
                    </div>
                    <div class='content'>
                        <span class='title fw-bold'>$product_title</span>
                        <div class='desc'>
                            <span>RM$product_price</span>
                        </div>
                    </div>
                </div>
            </div>
            ";
        }
    }
}

// view details function 
function viewDetails()
{
    global $con;
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        $select_product_query = "SELECT * FROM `products` WHERE product_id=$product_id AND status='true'";
        $select_product_result = mysqli_query($con, $select_product_query);
        $num_of_rows = mysqli_num_rows($select_product_result);
        if ($num_of_rows == 0) {
            echo "<h2 class='text-center'>Product not found or unavailable</h2>";
        } else {
            while ($row = mysqli_fetch_assoc($select_product_result)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_desc = $row['product_description'];
                $product_image_one = $row['product_image_one'];
                $product_image_two = $row['product_image_two'];
                $product_image_three = $row['product_image_three'];
                $product_price = $row['product_price'];
                $category_id = $row['category_id'];
                $brand_id = $row['brand_id'];
                echo "
                <div class='row mx-0 justify-content-md-center gap-3 gap-md-0'>
                <div class='col-md-2'>
                    <div class='prod-imgs'>
                        <img src='./admin/product_images/$product_image_one' alt='$product_title'>
                        <img src='./admin/product_images/$product_image_two' alt='$product_title'>
                        <img src='./admin/product_images/$product_image_three' alt='$product_title'>
                    </div>
                </div>
                <div class='col-md-5'>
                    <div class='main-img'>
                        <img src='./admin/product_images/$product_image_one' alt='$product_title'>
                    </div>
                </div>
                <div class='col-md-5'>
                    <div class='info d-flex flex-column gap-2'>
                        <h4 class='fw-bold'>$product_title</h4>
                        <h4>
                            RM$product_price
                        </h4>
                        <p>
                            $product_desc
                        </p>
                        <div class='divider'>
                        </div>
                        <form action='products.php?add_to_cart=$product_id'>
                            <div class='buy-item d-flex gap-3 justify-content-center align-items-center'>
                                <div>
                                    <input type='hidden' class='form-control' name='add_to_cart' id='add_to_cart' value='$product_id'/>
                                    <input type='submit' class='btn btn-primary' value='Buy Now'>
                                </div>
                            </div>
                        </form>
                        <div class='delivery d-flex flex-column my-4 gap-3'>
                            <div class='d-flex gap-2 align-items-center'>
                                <span>
                                    <svg width='40' height='40' viewBox='0 0 40 40' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                        <g clip-path='url(#clip0_261_4865)'>
                                            <path d='M33.3327 18.3334C32.9251 15.4004 31.5645 12.6828 29.4604 10.5992C27.3564 8.51557 24.6256 7.18155 21.6888 6.80261C18.752 6.42366 15.7721 7.02082 13.208 8.5021C10.644 9.98337 8.6381 12.2666 7.49935 15M6.66602 8.33335V15H13.3327' stroke='black' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' />
                                            <path d='M6.66602 21.6667C7.07361 24.5997 8.43423 27.3173 10.5383 29.4009C12.6423 31.4845 15.3731 32.8185 18.3099 33.1974C21.2467 33.5764 24.2266 32.9792 26.7907 31.4979C29.3547 30.0167 31.3606 27.7335 32.4994 25M33.3327 31.6667V25H26.666' stroke='black' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' />
                                        </g>
                                        <defs>
                                            <clipPath id='clip0_261_4865'>
                                                <rect width='40' height='40' fill='white' />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                <div class='d-flex flex-column gap-2'>
                                    <h6>Return Delivery</h6>
                                    <span>Free 30 Days Delivery Returns. Details</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                ";
            }
        }
    }
}

// get Ip Address Function
function getIPAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// cart function
function cart($num_of_items = 1)
{
    if (isset($_GET['add_to_cart'])) {
        global $con;
        $getIpAddress = getIPAddress();
        $getProductId = $_GET['add_to_cart'];
        $select_query = "SELECT * FROM `card_details` WHERE ip_address='$getIpAddress' AND product_id=$getProductId";
        $select_result = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($select_result);
        if ($num_of_rows > 0) {
            echo "<script>alert('This item is already present in Cart');</script>";
            echo "<script>window.open('products.php','_self');</script>";
        } else {
            $insert_query = "INSERT INTO `card_details` (product_id,ip_address,quantity) VALUES ($getProductId,'$getIpAddress',1)";
            $insert_result = mysqli_query($con, $insert_query);
            echo "<script>alert('This item added to Cart');</script>";
            echo "<script>window.open('products.php','_self');</script>";
        }
    }
}

// get cart item numbers function 
function cart_item()
{
    if (isset($_GET['add_to_cart'])) {
        global $con;
        $getIpAddress = getIPAddress();
        $select_query = "SELECT * FROM `card_details` WHERE ip_address='$getIpAddress' ";
        $select_result = mysqli_query($con, $select_query);
        $count_cart_items = mysqli_num_rows($select_result);
    } else {
        global $con;
        $getIpAddress = getIPAddress();
        $select_query = "SELECT * FROM `card_details` WHERE ip_address='$getIpAddress' ";
        $select_result = mysqli_query($con, $select_query);
        $count_cart_items = mysqli_num_rows($select_result);
    }
    echo $count_cart_items;
}

// total price function 
function total_cart_price()
{
    global $con;
    $getIpAddress = getIPAddress();
    $total_price = 0;
    $cart_query = "SELECT * FROM `card_details` WHERE ip_address='$getIpAddress'";
    $cart_result = mysqli_query($con, $cart_query);
    while ($row = mysqli_fetch_array($cart_result)) {
        $product_id = $row['product_id'];
        $select_product_query = "SELECT * FROM `products` WHERE product_id=$product_id";
        $select_product_result = mysqli_query($con, $select_product_query);
        while ($row_product_price = mysqli_fetch_array($select_product_result)) {
            $product_price = array($row_product_price['product_price']);
            $product_values = array_sum($product_price);
            $total_price += $product_values;
        }
    }
    echo $total_price;
}

// get user order details
function get_user_order_details()
{
    global $con;
    $username = $_SESSION['username'];
    $get_details_query = "SELECT * FROM `user_table` WHERE username = '$username'";
    $get_details_result = mysqli_query($con, $get_details_query);
    while ($row_query = mysqli_fetch_array($get_details_result)) {
        $user_id = $row_query['user_id'];
        if (!isset($_GET['edit_account'])) {
            if (!isset($_GET['my_orders'])) {
                if (!isset($_GET['delete_account'])) {
                    $get_orders_query = "SELECT * FROM `user_orders` WHERE user_id='$user_id' AND payment_status='pending'";
                    $get_orders_result = mysqli_query($con,$get_orders_query);
                    $row_orders_count = mysqli_num_rows($get_orders_result);
                    if($row_orders_count > 0){
                        echo "<h3 class='text-center mb-3'>You have <span class='text-2'>$row_orders_count</span> pending orders</h3>
                            <a href='profile.php?my_orders' class='text-center text-decoration-underline fs-5'>Order details</a>
                        ";
                    }else{
                        echo "<h3 class='text-center mb-3'>You have <span class='text-success'>0</span> pending orders</h3>
                            <a href='../index.php' class='text-center text-decoration-underline fs-5'>Explore products</a>
                        ";
                    }
                }
            }
        }
    }
}


?>