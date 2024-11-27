<?php
include('./includes/connect.php');
include('./functions/common_functions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund & Return Policy - Synergy Zyklen</title>

    <link rel="icon" type="image/x-icon" href="./assets/images/Synergy-Zyklen-Logo.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/images/Synergy-Zyklen-Logo.jpg">
    
    <link rel="stylesheet" href="./assets/css/bootstrap.css" />
    <link rel="stylesheet" href="./assets/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .policy-section {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .policy-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .policy-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .policy-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .policy-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .policy-card h2 {
            color: #2c3e50;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }

        .policy-card p {
            color: #34495e;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .policy-card ul {
            color: #34495e;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .policy-card li {
            margin-bottom: 1rem;
        }

        .highlight-box {
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 0 8px 8px 0;
        }

        .contact-box {
            background: #e8f4fc;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            margin-top: 3rem;
        }

        .contact-box h3 {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .telegram-button {
            background-color: #0088cc;
            color: white;
            padding: 15px 40px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            margin-top: 20px;
        }

        .telegram-button:hover {
            background-color: #006699;
            transform: translateY(-2px);
            color: white;
        }

        .icon-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: #3498db;
            border-radius: 50%;
            margin-bottom: 1rem;
        }

        .icon-box i {
            color: white;
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <!-- upper-nav -->
    <div class="upper-nav primary-bg p-2 px-3 text-center text-break">
        <span>Welcome to Synergy Zyklen - <a href="./products.php">Shop Now</a></span>
    </div>
    <!-- upper-nav -->

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
                        <a class="nav-link" aria-current="page" href="./index.php">Home</a>
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
                <form class="d-flex" action="search_product.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                    <input type="submit" value="Search" class="btn btn-outline-primary" name="search_data_product">
                </form>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="./cart.php"><i class="fas fa-shopping-cart"></i>
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
                        <a class="nav-link d-flex align-items-center gap-1" href="./users_area/profile.php">
                            <i class="fas fa-user"></i>
                            <?php
                            if(!isset($_SESSION['username'])){
                                echo "<span>Welcome guest</span>";
                            } else {
                                echo "<span>Welcome " . $_SESSION['username'] . "</span>";
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
                    } else {
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

    <section class="policy-section">
        <div class="container">
            <div class="policy-header">
                <h1>Refund And Return Policy</h1>
                <p class="text-muted">Last updated: <?php echo date("F Y"); ?></p>
            </div>
            
            <div class="policy-content">
                <div class="policy-card">
                    <div class="text-center mb-4">
                        <div class="icon-box">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                    </div>
                    <h2>Warranty</h2>
                    <p>All items are covered by a warranty for replacement within 3 days of the parcel received date. The warranty includes the replacement of products at no cost, with Synergy Zyklen covering the shipping expenses.</p>
                    
                    <div class="highlight-box">
                        <p class="mb-0">Warranty coverage extends to:</p>
                        <ul class="mb-0">
                            <li>Missing products</li>
                            <li>Broken items (due to leakage or cracks) caused by manufacturing defects</li>
                        </ul>
                    </div>

                    <p>To request warranty service, simply take a photo of the broken or missing item along with the shipping bag for proof of delivery. Please note that failure to provide this documentation may result in voiding the warranty request.</p>
                </div>

                <div class="policy-card">
                    <div class="text-center mb-4">
                        <div class="icon-box">
                            <i class="fas fa-undo-alt"></i>
                        </div>
                    </div>
                    <h2>Refund</h2>
                    <p>Items sold are generally not eligible for refunds. However, if there's an error in processing your order by our team, you may request a refund.</p>
                    
                    <div class="highlight-box">
                        <p class="mb-0"><i class="fas fa-info-circle me-2"></i>For assistance with your refund request, please reach out to our support team.</p>
                    </div>
                </div>

                <div class="contact-box">
                    <h3>Need Help?</h3>
                    <p>Our support team is here to assist you with any questions about our refund and warranty policy.</p>
                    <a href="https://t.me/+RH-IFpecM_s5OGM9" class="telegram-button">
                        <i class="fab fa-telegram-plane me-2"></i> Contact Support
                    </a>
                </div>
            </div>
        </div>
    </section>

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

    <script src="./assets/js/bootstrap.bundle.js"></script>
</body>

</html>