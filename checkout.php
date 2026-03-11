<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
    $total = 0;
    foreach ($_SESSION['cart'] as $id => $qty) {
        $res = $conn->query("SELECT * FROM products WHERE id=$id");
        if ($row = $res->fetch_assoc()) {
            $total += $row['price'] * $qty;
        }
    }
    $_SESSION['grand_total'] = $total;
    header("Location: checkout.php");
    exit;
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Your cart is empty!");
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="col-md-6 mx-auto">

            <h3>Checkout</h3>
            <hr>

            <table class="table">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>


                <?php
                $grandTotal = 0;

                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {

                        $total = $item['price'] * $item['qty'];
                        $grandTotal += $total;
                ?>
                        <tr>
                    
                            <td><?= $item['name'] ?></td>
                            <td>Rs. <?= $item['price'] ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td>Rs. <?= $total ?></td>
                            <td>
                                <a href="cart.php?remove=<?= $item['id'] ?>" class="btn btn-danger btn-sm">
                                    Remove
                                </a>
                            </td>
                        </tr>
                <?php }
                } ?>

                <tr>
                    <td colspan="3" align="right"><strong>Grand Total:</strong></td>
                    <td colspan="2"><strong>Rs. <?= $grandTotal ?></strong></td>
            </table>

            <hr>

            <form method="POST" action="place_order.php">

                <input type="hidden" name="total_amount" value="<?= $total ?>">

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Payment Method</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="COD">Cash on Delivery</option>
                        <option value="Card">Card</option>
                    </select>
                </div>

                <button type="submit" name="place_order" class="btn btn-success w-100">
                    Place Order
                </button>

            </form>

        </div>
    </div>

</body>

</html>