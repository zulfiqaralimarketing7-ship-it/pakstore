<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pakstore";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB Failed: " . $conn->connect_error);
}
?>
