<?php
session_start();
include "db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "../uploads/$image");

    $stmt = $conn->prepare("INSERT INTO products (name,description,price,image,category_id) VALUES (?,?,?,?,?)");
    $stmt->bind_param("ssisi", $name, $desc, $price, $image, $category_id);
    $stmt->execute();

    header("Location: http://localhost/Pak%20Store/admin/manage_products.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-5">
        <h2>Add Product</h2>

        <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" class="form-control mb-3" placeholder="Product Name" required>
            <textarea name="description" class="form-control mb-3" placeholder="Description"></textarea>
            <input type="number" name="price" class="form-control mb-3" placeholder="Price" required>
            <?php
            $cat = $conn->query("SELECT * FROM categories");
            ?>

            <select name="category_id" class="form-control mb-3" required>
                <option value="">Select Category</option>
                <?php while ($c = $cat->fetch_assoc()) { ?>
                    <a href="products.php?category=<?= $c['id'] ?>&search=<?= $search ?>">
                        <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                    <?php } ?>
            </select>
            <input type="file" name="image" class="form-control mb-3" required>
            <button name="submit" class="btn btn-success">Add Product</button>
        </form>

    </div>

</body>

</html>