<?php
session_start();
include "../db.php";
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<?php
include "../db.php";
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-5">
        <h2>Manage Products</h2>

        <a href="add_product.php" class="btn btn-primary mb-3">+ Add New</a>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><img src="../uploads/<?= $row['image'] ?>" width="60"></td>
                    <td><?= $row['name'] ?></td>
                    <td>Rs <?= $row['price'] ?></td>
                    <td>
                        <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_product.php?id=<?= $row['id'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete this product?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>

        </table>
    </div>

</body>

</html>