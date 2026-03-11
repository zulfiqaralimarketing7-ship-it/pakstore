<?php
include "db.php";
$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Orders - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-5">
        <h2>Order Management</h2>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['user_id'] ?></td>
                    <td>Rs <?= $row['total_amount'] ?></td>
                    <td><?= $row['payment_method'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <a href="update_order.php?id=<?= $row['id'] ?>&status=Delivered" class="btn btn-success btn-sm">Mark Delivered</a>
                    </td>
                </tr>
            <?php } ?>

        </table>
    </div>

</body>

</html>