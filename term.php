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
    <title>Terms and Conditions - Synergy Zyklen</title>

    <link rel="icon" type="image/x-icon" href="./assets/images/Synergy-Zyklen-Logo.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/images/Synergy-Zyklen-Logo.jpg">
    
    <link rel="stylesheet" href="./assets/css/bootstrap.css" />
    <link rel="stylesheet" href="./assets/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .terms-section {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .terms-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .terms-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .terms-content {
            max-width: 900px;
            margin: 0 auto;
        }

        .terms-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            margin-bottom: 2rem;
        }

        .terms-card h2 {
            color: #2c3e50;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }

        .terms-card p {
            color: #34495e;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .welcome-box {
            background: #e8f4fc;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 3rem;
        }

        .welcome-box h3 {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .highlight-text {
            color: #3498db;
            font-weight: 600;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 0 8px 8px 0;
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(to right, #3498db, transparent);
            margin: 3rem 0;
        }

        .terms-link {
            color: #3498db;
            text-decoration: none;
            border-bottom: 1px dotted #3498db;
        }

        .terms-link:hover {
            color: #2980b9;
            border-bottom-style: solid;
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

    <section class="terms-section">
        <div class="container">
            <div class="terms-header">
                <h1>Terms and Conditions</h1>
                <p class="text-muted">Last updated: <?php echo date("F Y"); ?></p>
            </div>
            
            <div class="terms-content">
                <div class="welcome-box">
                    <h3>Welcome to Synergy Zyklen!</h3>
                    <p class="mb-0">Please read these terms and conditions carefully before using our services.</p>
                </div>

                <div class="terms-card">
                    <p>These terms and conditions outline the rules and regulations for the use of Synergy Zyklen Solution's Website.</p>
                    
                    <div class="info-box">
                        <p class="mb-0">By accessing this website, we assume you accept these terms and conditions. Do not continue to use Synergy Zyklen if you do not agree to take all of the terms and conditions stated on this page.</p>
                    </div>
                </div>

                <div class="terms-card">
                    <h2>Terminology</h2>
                    <p>The following terminology applies to these Terms and Conditions, Privacy Statement, Disclaimer Notice, and all Agreements:</p>
                    <ul class="mb-4">
                        <li><span class="highlight-text">"Client"</span>, <span class="highlight-text">"You"</span>, and <span class="highlight-text">"Your"</span> refers to you, the person logging on to this website and complying with the Company's terms and conditions.</li>
                        <li><span class="highlight-text">"The Company"</span>, <span class="highlight-text">"Ourselves"</span>, <span class="highlight-text">"We"</span>, <span class="highlight-text">"Our"</span> and <span class="highlight-text">"Us"</span> refers to our Company.</li>
                        <li><span class="highlight-text">"Party"</span>, <span class="highlight-text">"Parties"</span>, or <span class="highlight-text">"Us"</span> refers to both the Client and ourselves.</li>
                    </ul>
                    <p>All terms refer to the offer, acceptance, and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client's needs in respect of the provision of the Company's stated services, in accordance with and subject to, prevailing law of Malaysia.</p>
                    <p>Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>
                </div>

                <div class="section-divider"></div>

                <div class="terms-card">
                    <h2>System Changes and Ownership Rights</h2>
                    <p>Synergy Zyklen reserves the right to modify, update, or discontinue any part of the system, website, or services at any time without prior notice. All intellectual property rights, including but not limited to software, systems, and content related to Synergy Zyklen, remain the sole property of Synergy Zyklen.</p>
                    
                    <div class="info-box">
                        <p>By continuing to use our website or system following any changes, you agree to comply with and be bound by the modified terms and conditions. It is your responsibility to review these terms periodically to stay informed about any updates.</p>
                    </div>

                    <p>Synergy Zyklen will not be held liable for any damages, direct or indirect, caused by system changes. The Company's decision on any matter related to system modifications will be final and binding.</p>
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