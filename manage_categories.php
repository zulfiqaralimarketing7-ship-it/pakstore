<?php
session_start();
include "../db.php";
$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-5">
        <h2>Manage Categories</h2>

        <a href="add_category.php" class="btn btn-primary mb-3">+ Add Category</a>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                </tr>
            <?php } ?>

        </table>

    </div>

</body>

</html>