<?php
include "db.php";

$start = $_GET['start'] ?? 0;
$limit = 6;

$stmt = $conn->prepare("
    SELECT * FROM products 
    ORDER BY id DESC 
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ii", $limit, $start);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
?>

    <div class="col-md-4 fade-in" style="animation-delay: <?= ($start / $limit) * 0.2 ?>s;">
        <div class="card h-100 shadow-sm">
            <img src="uploads/<?= $row['image'] ?>"
                class="card-img-top"
                style="height:200px; object-fit:cover;">
            <div class="card-body">
                <h5><?= $row['name'] ?></h5>
                <p>Rs <?= $row['price'] ?></p>
                <a href="cart.php?add=<?= $row['id'] ?>"
                    class="btn btn-warning w-100">
                    Add to Cart
                </a>
            </div>
        </div>
    </div>

<?php } ?>