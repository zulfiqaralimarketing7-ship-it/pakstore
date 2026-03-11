<?php
session_start();
include "../db.php";

/* Total Products */
$total_products = $conn->query("SELECT COUNT(*) as total FROM products")
    ->fetch_assoc()['total'];

/* Total Orders */
$total_orders = $conn->query("SELECT COUNT(*) as total FROM orders")
    ->fetch_assoc()['total'];

/* Total Revenue */
$total_revenue = $conn->query("SELECT SUM(total_amount) as total FROM orders")
    ->fetch_assoc()['total'] ?? 0;

/* Monthly Sales */
$sales_query = $conn->query("
    SELECT MONTH(created_at) as month, 
           SUM(total_amount) as revenue
    FROM orders
    GROUP BY MONTH(created_at)
");

$months = [];
$revenues = [];

while ($row = $sales_query->fetch_assoc()) {
    $months[] = date("M", mktime(0, 0, 0, $row['month'], 1));
    $revenues[] = $row['revenue'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="container py-5">
        <h2>Admin Dashboard</h2>

        <div class="row my-4">

            <div class="col-md-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5>Total Products</h5>
                        <h2><?= $total_products ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5>Total Orders</h5>
                        <h2><?= $total_orders ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5>Total Revenue</h5>
                        <h2>Rs <?= $total_revenue ?></h2>
                    </div>
                </div>
            </div>

        </div>

        <div class="card shadow p-4">
            <h5>Monthly Sales</h5>
            <canvas id="salesChart"></canvas>
        </div>

    </div>

    <script>
        const ctx = document.getElementById('salesChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($months) ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?= json_encode($revenues) ?>,
                    backgroundColor: '#ff9900'
                }]
            },
        });
    </script>

</body>

</html>