<?php
session_start();
include "db.php";

$uid = $_SESSION['user_id'];

$res = $conn->query("SELECT * FROM orders WHERE user_id=$uid ORDER BY id DESC");
?>

<h2>My Orders</h2>

<table class="table table-bordered text-center">
    <tr>
        <th>Order ID</th>
        <th>Total</th>
        <th>Status</th>
        <th>Date</th>
    </tr>

    <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
            <td>#<?= $row['id'] ?></td>
            <td>Rs <?= $row['total_amount'] ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
    <?php endwhile; ?>

</table>