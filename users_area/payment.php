<?php
session_start();
include('../includes/connect.php');
include('../functions/common_functions.php');

$amount = isset($_GET['amount']) ? floatval($_GET['amount']) : 0;
$bank = isset($_GET['bank']) ? htmlspecialchars($_GET['bank']) : '';
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// If user_id is not in GET parameters, try to get it from session
if ($user_id === 0 && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Make sure we have a valid user_id before proceeding
    if ($user_id > 0) {
        header("Location: order.php?user_id=" . $user_id);
        exit();
    } else {
        // Handle error - redirect to login or show error message
        echo "<script>alert('Invalid user session. Please login again.');</script>";
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment - Synergy Zyklen</title>

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
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-semibold mb-6">Confirm Your Payment</h1>
            <div class="bg-gray-100 p-4 rounded-md mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Amount:</span>
                    <span class="font-medium">RM <?php echo number_format($amount, 2); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Bank:</span>
                    <span class="font-medium"><?php echo ucfirst($bank); ?></span>
                </div>
            </div>
            <form action="<?php echo $_SERVER['PHP_SELF'] . "?user_id=" . $user_id; ?>" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <p class="mb-4 text-gray-600">Click the button below to confirm your payment. You will be redirected to complete your order.</p>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Proceed to Pay
                </button>
            </form>
        </div>
    </div>
</body>
</html>