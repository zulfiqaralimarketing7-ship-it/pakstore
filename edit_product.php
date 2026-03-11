<?php
                                    session_start();
                                    if ($_SESSION['role'] != 'admin') {
                                        header("Location: C:\\xampp\\htdocs\\Pak Store\\login.php");
                                        exit;
                                    }
                                ?>
<?php
include "../db.php";

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/$image");

        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=? WHERE id=?");
        $stmt->bind_param("ssisi", $name, $desc, $price, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=? WHERE id=?");
        $stmt->bind_param("ssii", $name, $desc, $price, $id);
    }

    $stmt->execute();
    header("Location: manage_products.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-5">
        <h2>Edit Product</h2>

        <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" value="<?= $product['name'] ?>" class="form-control mb-3" required>
            <textarea name="description" class="form-control mb-3"><?= $product['description'] ?></textarea>
            <input type="number" name="price" value="<?= $product['price'] ?>" class="form-control mb-3" required>

            <img src="../uploads/<?= $product['image'] ?>" width="100" class="mb-3"><br>

            <input type="file" name="image" class="form-control mb-3">

            <button name="update" class="btn btn-success">Update Product</button>
        </form>

    </div>

</body>

</html>