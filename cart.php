<?php
session_start();
include "db.php";

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* ADD TO CART */
if (isset($_POST['add_to_cart'])) {

    $id    = $_POST['id'];
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty']++;
    } else {
        $_SESSION['cart'][$id] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'qty' => 1
        ];
    }

    header("Location: cart.php");
    exit;
}

/* REMOVE */
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit;
}
?>

<h2>My Cart</h2>

<table border="1"  cellpadding="10" width="100%">
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
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
                <td><img src="<?= $item['image'] ?>" width="70"></td>
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
        <td colspan="4" align="right"><strong>Grand Total:</strong></td>
        <td colspan="2"><strong>Rs. <?= $grandTotal ?></strong></td>
        <hr>
        <td colspan="6" align="right">
            <a href="checkout.php" class="btn btn-success btn-lg">Checkout</a>
    </tr>

</table>