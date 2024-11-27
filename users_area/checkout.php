<?php
session_start();
include('../includes/connect.php');
include('../functions/common_functions.php');

// Get user details if logged in
$user_data = [];
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_query = "SELECT * FROM `user_table` WHERE username='$username'";
    $user_result = mysqli_query($con, $user_query);
    $user_data = mysqli_fetch_assoc($user_result);
    $user_id = $user_data['user_id'];
}

// Get cart items
$getIpAddress = getIPAddress();
$cart_query = "SELECT cd.*, p.product_title, p.product_image_one, p.product_price 
               FROM `card_details` cd
               JOIN `products` p ON cd.product_id = p.product_id
               WHERE cd.ip_address='$getIpAddress'";
$cart_result = mysqli_query($con, $cart_query);

// Calculate totals
$subtotal = 0;
$shipping = 10; // Default shipping cost
$savings = 0;
$discount = 0;
$discount_code = '';

while ($row = mysqli_fetch_assoc($cart_result)) {
    $subtotal += $row['quantity'] * $row['product_price'];
}

$total = $subtotal + $shipping - $savings - $discount;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];
    $selected_bank = $_POST['selected_bank'] ?? '';
    
    // Recalculate total
    $total = $subtotal + $shipping - $savings - $discount;
    
     // Redirect based on payment method
     if ($payment_method === 'banking') {
        header("Location: payment.php?amount=$total&bank=$selected_bank&user_id=" . $user_id);
        exit();
    } elseif ($payment_method === 'cash') {
        header("Location: order.php?user_id=" . $user_id);
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Synergy Zyklen</title>

    <link rel="icon" type="image/x-icon" href="../assets/images/Synergy-Zyklen-Logo.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/Synergy-Zyklen-Logo.jpg">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-1">Checkout</h1>
        <p class="text-sm text-gray-500 mb-8">Shipping charges are confirmed at checkout.</p>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="grid lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="space-y-8">
                        <!-- User Info -->
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <?php
                                if(isset($_SESSION['username'])) {
                                    $username = $_SESSION['username'];
                                    $select_user_img = "SELECT * FROM `user_table` WHERE username='$username'";
                                    $select_user_img_result = mysqli_query($con, $select_user_img);
                                    $row_user_img = mysqli_fetch_array($select_user_img_result);
                                    $userImg = $row_user_img['user_image'];
                                    ?>
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden">
                                        <img src="./user_images/<?php echo htmlspecialchars($userImg); ?>" alt="<?php echo htmlspecialchars($username); ?> photo" class="w-full h-full object-cover">
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden">
                                        <span class="text-sm">👤</span>
                                    </div>
                                    <?php
                                }
                                ?>
                                <h2 class="font-medium"><?php echo htmlspecialchars($user_data['username'] ?? ''); ?></h2>
                            </div>
                            <div class="grid gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" value="<?php echo htmlspecialchars($user_data['user_email'] ?? ''); ?>" readonly class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Phone</label>
                                    <input type="tel" value="<?php echo htmlspecialchars($user_data['user_mobile'] ?? ''); ?>" readonly class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Address</Address></label>
                                    <input type="add" value="<?php echo htmlspecialchars($user_data['user_address'] ?? ''); ?>" readonly class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Details -->
                        <div>
                            <h2 class="font-medium mb-4">Shipping Details</h2>
                            <?php
                            mysqli_data_seek($cart_result, 0);
                            while ($row = mysqli_fetch_assoc($cart_result)):
                            ?>
                            <div class="flex gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                                <div class="w-24 h-24 bg-white rounded-lg overflow-hidden">
                                    <img src="../admin/product_images/<?php echo htmlspecialchars($row['product_image_one']); ?>" alt="<?php echo htmlspecialchars($row['product_title']); ?>" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium"><?php echo htmlspecialchars($row['product_title']); ?></h3>
                                    <p class="text-sm text-gray-500">Quantity: <?php echo $row['quantity']; ?></p>
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex items-center gap-2">
                                            <span class="w-8 text-center"><?php echo $row['quantity']; ?></span>
                                        </div>
                                        <div>
                                            <p class="font-medium">RM<?php echo number_format($row['product_price'], 2); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>

                        <!-- Payment -->
        <div>
            <h2 class="font-medium mb-4">Payment</h2>
            <div class="space-y-4">
                <div class="border rounded-lg p-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="payment_method" value="banking" checked class="form-radio">
                        <span class="font-medium">Online Banking</span>
                    </label>
                    <div class="mt-4 ml-6">
                        <label for="bank-select" class="block text-sm font-medium text-gray-700 mb-2">Select Bank</label>
                        <select id="bank-select" name="selected_bank" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Choose a bank</option>
                            <option value="maybank">Maybank</option>
                            <option value="cimb">CIMB Bank</option>
                            <option value="bankislam">Bank Islam</option>
                            <option value="publicbank">Public Bank</option>
                            <option value="rhb">RHB Bank</option>
                        </select>
                    </div>
                </div>
                <div class="border rounded-lg p-4">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="payment_method" value="cash" class="form-radio">
                        <span class="font-medium">Cash</span>
                    </label>
                </div>
            </div>
        </div>

                <!-- Summary -->
                <div class="lg:col-span-1">
                    <div class="border rounded-lg p-4">
                        <h2 class="font-medium mb-4">Summary</h2>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Items in the Cart</span>
                                <span>RM<?php echo number_format($subtotal, 2); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Shipping</span>
                                <span>RM<?php echo number_format($shipping, 2); ?></span>
                            </div>
                            <?php if ($savings > 0): ?>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Savings applied</span>
                                <span>RM<?php echo number_format($savings, 2); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if ($discount > 0): ?>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Discount Code (<?php echo htmlspecialchars($discount_code); ?>)</span>
                                <span>RM<?php echo number_format($discount, 2); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex justify-between font-medium mb-6">
                            <span>Total</span>
                            <span>RM<?php echo number_format($total, 2); ?></span>
                        </div>
                        <div class="space-y-4">
                            <button type="submit" class="w-full bg-zinc-900 text-white py-3 rounded-lg">PROCEED TO PAYMENT</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deliveryMethods = document.querySelectorAll('input[name="delivery_method"]');
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const bankSelect = document.getElementById('bank-select');

            deliveryMethods.forEach(method => {
                method.addEventListener('change', function() {
                    const details = this.closest('.border').querySelector('.mt-2');
                    document.querySelectorAll('.border .mt-2').forEach(el => el.style.display = 'none');
                    if (details) {
                        details.style.display = 'block';
                    }
                });
            });

            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    if (this.value === 'banking') {
                        bankSelect.parentElement.style.display = 'block';
                    } else {
                        bankSelect.parentElement.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>