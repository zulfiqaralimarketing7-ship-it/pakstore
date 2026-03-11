<?php
include "auth.php";

// Ensure the Stripe PHP library is loaded. 
// If you haven't installed it via composer, run: composer require stripe/stripe-php
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

\Stripe\Stripe::setApiKey("sk_test_51T6Zq9RlJidN6DDmXnQx3DhVEJsEVxKmYqN6pFvF8i3Y1B2c9D4e5f6G7h8I9j0K1l2M3n4O5p6Q7r8S9t0U1v2W3x4Y5z6A7b8C9d0E1f2G3h4I5j6K7l8M9n0O1p2Q3r4S5t6U7v8W9x0Y1z2A3b4C5d6E7f8G9h0I1j2K3l4M5n6O7p8Q9r0S1t2U3v4W5x6Y7z8A9b0C1d2E3f4G5h6I7j8K9l0M1n2O3p4Q5r6S7t8U9v0W1x2Y3z4A5b6C7d8E9f0G1h2I3j4K5l6M7n8O9p0Q1r2S3t4U5v6W7x8Y9z0A1b2C3d4E5f6G7h8I9j0K1l2M3n4O5p6Q7r8S9t0U1v2W3x4Y5z6A7b8C9d0E1f2G3h4I5j6K7l8M9n0O1p2Q3r4S5t6U7v8W9x0Y1z2A3b4C5d6E7f8G9h0I1j2K3l4M5n6O7p8Q9r0S1t2U3v4W5x6Y7z8");

$data = json_decode(file_get_contents("php://input"), true);
$paymentMethod = $data['id'];

$amount = $_SESSION['grand_total'] * 100;

try {
    $payment = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'pkr',
        'payment_method' => $paymentMethod,
        'confirm' => true
    ]);

    echo json_encode(["success" => true]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>