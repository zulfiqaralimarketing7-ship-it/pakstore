<?php
include "db.php";

$search = $_GET['search'] ?? '';

$stmt = $conn->prepare("
    SELECT * FROM products 
    WHERE name LIKE ? OR description LIKE ?
    LIMIT 6
");

$like = "%$search%";
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
?>

    <div class="col-md-4">
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script>
        document.getElementById("liveSearch").addEventListener("keyup", function() {

            let value = this.value;

            fetch("search_ajax.php?search=" + value)
                .then(res => res.text())
                .then(data => {
                    document.getElementById("productArea").innerHTML = data;
                });

        });
    </script>
    <script>
        let start = 6;
        let loading = false;

        window.addEventListener("scroll", function() {

            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 200) {

                if (loading) return;
                loading = true;

                document.getElementById("loading").style.display = "block";

                fetch("load_more.php?start=" + start)
                    .then(res => res.text())
                    .then(data => {

                        if (data.trim() !== "") {
                            document.getElementById("productArea").innerHTML += data;
                            start += 6;
                            loading = false;
                        }

                        document.getElementById("loading").style.display = "none";
                    });
            }
        });
    </script>
</body>

</html>