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
    <title>License Agreement - Synergy Zyklen</title>

    <link rel="icon" type="image/x-icon" href="./assets/images/Synergy-Zyklen-Logo.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/images/Synergy-Zyklen-Logo.jpg">
    
    <link rel="stylesheet" href="./assets/css/bootstrap.css" />
    <link rel="stylesheet" href="./assets/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .license-section {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .license-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .license-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a365d;
            margin-bottom: 20px;
        }

        .license-content {
            max-width: 900px;
            margin: 0 auto;
        }

        .license-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            margin-bottom: 2rem;
        }

        .license-card h2 {
            color: #1a365d;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }

        .license-card p {
            color: #2d3748;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .restrictions-list {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 2rem;
            margin: 1.5rem 0;
            border-left: 4px solid #3182ce;
        }

        .restrictions-list li {
            color: #2d3748;
            margin-bottom: 1rem;
            line-height: 1.6;
            position: relative;
            padding-left: 1.5rem;
        }

        .restrictions-list li::before {
            content: "•";
            color: #3182ce;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .important-notice {
            background: #ebf8ff;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-left: 4px solid #3182ce;
        }

        .important-notice p {
            margin-bottom: 0;
            color: #2c5282;
        }

        .highlight-text {
            color: #3182ce;
            font-weight: 600;
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(to right, #3182ce, transparent);
            margin: 3rem 0;
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

    <main class="license-section">
        <div class="container">
            <div class="license-header">
                <h1>License and System Ownership</h1>
                <p class="text-muted">Last updated: <?php echo date("F Y"); ?></p>
            </div>
            
            <div class="license-content">
                <div class="license-card">
                    <div class="important-notice">
                        <p>Please read this license agreement carefully before using the Synergy Zyklen system. By using the system, you agree to be bound by the terms of this license.</p>
                    </div>

                    <h2>Intellectual Property Rights</h2>
                    <p>All intellectual property rights related to the Synergy Zyklen system, website, and any associated software are owned exclusively by Synergy Zyklen Solution and/or its licensors. This includes, but is not limited to, the system's design, functionality, underlying code, and any related technologies. All rights are reserved, and no part of the system or its components may be used, reproduced, or distributed without explicit written consent from Synergy Zyklen Solution.</p>

                    <div class="section-divider"></div>

                    <h2>License Grant</h2>
                    <p>By using the Synergy Zyklen system or website, you are granted a limited, non-transferable, and revocable license to access and use the system for personal, non-commercial purposes, subject to the following restrictions:</p>

                    <div class="restrictions-list">
                        <ul class="list-unstyled">
                            <li>You must not republish, sell, rent, or sub-license the system or any material from Synergy Zyklen.</li>
                            <li>You must not reproduce, duplicate, copy, distribute, or exploit any part of the system for commercial purposes without prior written approval.</li>
                            <li>You must not attempt to reverse engineer, decompile, or create derivative works based on the system's software or any part of its functionalities.</li>
                            <li>Redistribution of content, materials, or system components is strictly prohibited without express permission.</li>
                        </ul>
                    </div>

                    <div class="section-divider"></div>

                    <h2>Enforcement</h2>
                    <p>Any unauthorized use or infringement upon the intellectual property rights of Synergy Zyklen may result in legal action. Synergy Zyklen reserves the right to revoke your access to the system at any time, should any breach of these terms occur.</p>

                    <div class="important-notice">
                        <p>For any questions regarding this license or to request permissions, please contact our legal department through our <a href="https://t.me/+RH-IFpecM_s5OGM9" class="highlight-text">Telegram Page</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

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