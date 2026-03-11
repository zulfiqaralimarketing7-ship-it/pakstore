<?php
include "db.php";
session_start();

$limit = 6;
$result = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT $limit");

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$limit = 6; // per page products
$offset = ($page - 1) * $limit;

$where = "WHERE 1";
$params = [];
$types = "";

if ($category) {
    $where .= " AND category_id=?";
    $params[] = $category;
    $types .= "i";
}

if ($search) {
    $where .= " AND (name LIKE ? OR description LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $types .= "ss";
}

/* COUNT TOTAL */
$count_sql = "SELECT COUNT(*) as total FROM products $where";
$stmt = $conn->prepare($count_sql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total_result = $stmt->get_result()->fetch_assoc();
$total_products = $total_result['total'];
$total_pages = ceil($total_products / $limit);

/* FETCH PRODUCTS */
$sql = "SELECT * FROM products $where ORDER BY id DESC LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($sql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Products - PakStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">PakStore</a>
            <a href="cart.php" class="btn btn-warning">🛒 Cart</a>
        </div>
    </nav>

    <div class="container my-5">

        <!-- SEARCH FORM -->
        <form method="GET" action="products.php" class="row mb-4">
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <?php
                    $cats = $conn->query("SELECT * FROM categories");
                    while ($c = $cats->fetch_assoc()) {
                    ?>
                        <option value="<?= $c['id'] ?>" <?= $c['id'] == $category ? 'selected' : '' ?>>
                            <?= $c['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div id="loading" class="row g-4 my-4" style="display:none;">

                <div class="col-md-4">
                    <div class="card">
                        <div class="skeleton" style="height:200px;"></div>
                        <div class="card-body">
                            <div class="skeleton mb-2" style="height:20px;"></div>
                            <div class="skeleton mb-2" style="height:15px;"></div>
                            <div class="skeleton" style="height:35px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="skeleton" style="height:200px;"></div>
                        <div class="card-body">
                            <div class="skeleton mb-2" style="height:20px;"></div>
                            <div class="skeleton mb-2" style="height:15px;"></div>
                            <div class="skeleton" style="height:35px;"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <input
                    type="text"
                    id="liveSearch"
                    name="search"
                    class="form-control"
                    placeholder="Search products...">
            </div>

            <div class="col-md-3">
                <button class="btn btn-warning w-100">Search</button>
            </div>
        </form>

        <div class="row">

            <!-- CATEGORY SIDEBAR -->
            <div class="col-md-3">
                <h5>Categories</h5>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="products.php">All Products</a>
                    </li>
                    <?php
                    $cats = $conn->query("SELECT * FROM categories");
                    while ($c = $cats->fetch_assoc()) {
                    ?>
                        <li class="list-group-item">
                            <a href="products.php?category=<?= $c['id'] ?>">
                                <?= $c['name'] ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <!-- PRODUCTS SECTION -->
            <div class="col-md-9">
                <h4 class="mb-3">Products</h4>

                <?php if ($result->num_rows == 0) { ?>
                    <div class="alert alert-warning">
                        No products found.
                    </div>
                <?php } ?>

                <div class="row g-4" id="productArea">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm">
                                <img src="uploads/<?= $row['image'] ?>"
                                    class="card-img-top"
                                    style="height:200px; object-fit:cover;">

                                <div class="card-body">
                                    <h5 class="card-title"><?= $row['name'] ?></h5>
                                    <p class="card-text">
                                        <?= substr($row['description'], 0, 60) ?>...
                                    </p>
                                    <h6 class="text-primary">Rs <?= $row['price'] ?></h6>

                                    <a href="cart.php?add=<?= $row['id'] ?>"
                                        class="btn btn-warning w-100">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>

        </div>
    </div>
    <nav class="mt-4">
        <ul class="pagination">

            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                        href="?page=<?= $i ?>&search=<?= $search ?>&category=<?= $category ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>

        </ul>
    </nav>

</body>

</html>