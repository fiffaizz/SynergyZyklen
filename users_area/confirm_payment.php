<?php
include("../includes/connect.php");
include("../functions/common_functions.php");
session_start();

if (!isset($_SESSION['username'])) {
    header('location:user_login.php');
    exit();
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $select_order_query = "SELECT * FROM `user_orders` WHERE order_id = '$order_id'";
    $select_order_result = mysqli_query($con, $select_order_query);
    $row_fetch = mysqli_fetch_array($select_order_result);
    $invoice_number = $row_fetch['invoice_number'];
    $amount_due = $row_fetch['amount_due'];
}

if (isset($_POST['confirm_payment'])) {
    $invoice_number = $_POST['invoice_number'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $insert_payment_query = "INSERT INTO `user_payments` (order_id, invoice_number, amount, payment_method) VALUES ($order_id, $invoice_number, $amount, '$payment_method')";
    $insert_payment_result = mysqli_query($con, $insert_payment_query);
    if ($insert_payment_result) {
        $update_orders_query = "UPDATE `user_orders` SET payment_status = 'paid' WHERE order_id = $order_id";
        $update_orders_result = mysqli_query($con, $update_orders_query);
        echo "<script>alert('Payment completed successfully');</script>";
        echo "<script>window.location.href='profile.php?my_orders';</script>";
    } else {
        echo "<script>alert('Payment failed. Please try again.');</script>";
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
            <h1 class="text-2xl font-semibold mb-6 text-center">Confirm Payment</h1>
            <form method="post" action="" class="space-y-4">
                <div>
                    <label for="invoice_number" class="block text-sm font-medium text-gray-700 mb-1">Invoice Number</label>
                    <input type="text" id="invoice_number" name="invoice_number" value="<?php echo htmlspecialchars($invoice_number); ?>" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50">
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount Due</label>
                    <input type="text" id="amount" name="amount" value="<?php echo htmlspecialchars($amount_due); ?>" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50">
                </div>
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                    <select id="payment_method" name="payment_method" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="" disabled selected>Select payment method</option>
                        <option value="online_banking">Online Banking</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>
                <div>
                    <button type="submit" name="confirm_payment" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Confirm Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>