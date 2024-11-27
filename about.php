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
    <title>About - Synergy Zyklen</title>

    <link rel="icon" type="image/x-icon" href="./assets/images/Synergy-Zyklen-Logo.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/images/Synergy-Zyklen-Logo.jpg">
    
    <link rel="stylesheet" href="./assets/css/bootstrap.css" />
    <link rel="stylesheet" href="./assets/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .about-section {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .about-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .about-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .about-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #34495e;
        }

        .vision-mission-section {
            padding: 60px 0;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .card-custom:hover {
            transform: translateY(-5px);
        }

        .card-body-custom {
            padding: 2rem;
        }

        .card-title-custom {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .highlight-text {
            color: #3498db;
            font-weight: 600;
        }

        .contact-section {
            background-color: #ffffff;
            padding: 60px 0;
            text-align: center;
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

        .divider {
            height: 4px;
            width: 60px;
            background-color: #3498db;
            margin: 20px auto;
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
                        <a class="nav-link active" href="./about.php">About</a>
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

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-header">
                <h1>WHO ARE WE?</h1>
                <div class="divider"></div>
            </div>
            <div class="about-content">
                <p class="text-center mb-5">
                    Embark on a journey with us at <span class="highlight-text">SYNERGY ZYKLEN SOLUTION</span> (CA0390369-H), where we redefine the essence of consumer essentials. As sellers of everyday products, we pride ourselves on delivering quality and satisfaction at every turn.
                </p>
                <p class="text-center mb-4">
                    Our mission is clear; to seamlessly integrate our meticulously crafted goods into the lives of our valued customers. The company is proudly 100% Bumiputera-owned, reflecting our deep-rooted commitment to promoting diversity and celebrating our cultural heritage.
                </p>
                <p class="text-center">
                    "<span class="highlight-text">SYNERGY</span>" is when entities collaborate to achieve a greater effect than their individual efforts. "<span class="highlight-text">ZYKLEN</span>," which means "cycles" in German, represents repeating patterns over time. Our system operates on the principle that each purchase contributes to a cycle of shared benefits, creating a continuous win-win scenario between us and our customers.
                </p>
            </div>
        </div>
    </section>

    <!-- Vision Mission & Objective Section -->
    <section class="vision-mission-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card card-custom">
                        <div class="card-body card-body-custom">
                            <h2 class="card-title-custom">Vision and Mission</h2>
                            <p>
                                At Synergy Zyklen, our dedication to a user-centric philosophy drives us to prioritize affordability through direct price control, eliminating the need for middlemen. We believe in achievable goals without the complexities of intermediaries, offering users the opportunity to earn supplementary income through product sales.
                            </p>
                            <p class="mb-0">
                                With Synergy Zyklen handling logistics and associated expenses, users can seize this opportunity without any initial capital investment, empowering them to embark on their entrepreneurial journey with ease.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom">
                        <div class="card-body card-body-custom">
                            <h2 class="card-title-custom">Objective</h2>
                            <p>
                                Welcome to the dawn of a spending revolution with Synergy Zyklen, where we're pioneering a new era of collaboration between our company and consumers, all geared towards mutual prosperity. Our mission is twofold: to enlighten the community and cultivate a culture of smart consumers.
                            </p>
                            <p class="mb-0">
                                In our innovative system, shopping transcends its conventional boundaries, evolving into a powerful asset. Through seamless synergy between our company and consumers, we empower individuals to transform their spending power into a strategic financial advantage.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <h2 class="mb-4">Any question about us?</h2>
            <div class="divider"></div>
            <p class="mb-4">
                Join our vibrant community and feel free to ask any questions you may have. We're committed to providing the best possible answers and support, so don't hesitate to reach out to us. Your inquiries are always welcome, and we'll do our utmost to assist you!
            </p>
            <a href="https://t.me/+RH-IFpecM_s5OGM9" class="telegram-button">
                <i class="fab fa-telegram-plane me-2"></i> Contact us on Telegram
            </a>
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