<?php
session_start();
include "db.php";

if (!isset($_POST['place_order'])) {
    header("Location: checkout.php");
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$name = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
$payment = $_POST['payment_method'] ?? '';
$total = $_POST['total_amount'] ?? 0;

if (empty($name) || empty($address) || empty($payment)) {
    die("All fields are required!");
}

/* Insert Order */
$stmt = $conn->prepare("
    INSERT INTO orders (user_id,name,address,payment_method,total_amount)
    VALUES (?,?,?,?,?)
");

$stmt->bind_param(
    "isssi",
    $_SESSION['user_id'],
    $name,
    $address,
    $payment,
    $total
);

$stmt->execute();

/* Clear Cart */
unset($_SESSION['cart']);

/* Show Success Message */

echo "<h2 style='text-align:center;margin-top:50px;'>
Order Placed Successfully 🎉
</h2>";
echo "<p style='text-align:center;'>
Thank you for shopping with us, $name! Your order has been received and is being processed. We will notify you once it is ready for delivery.
</p>";
echo "<div style='text-align:center;margin-top:30px;'>
<a href='index.php' style='padding:10px 20px;background-color:#28a745;color:white;text-decoration:none;border-radius:5px;'>
Continue Shopping
</a>
</div>";
?>

