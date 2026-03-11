<?php
session_start();
include "../db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location:  C:\\xampp\\htdocs\\Pak Store\\login.php");
    exit;
}
?>
<?php
include "../db.php";

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: manage_products.php");
exit;
?>