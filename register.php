<?php
session_start();
include "db.php";

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();

    $_SESSION['success'] = "Registration Successful! Please Login.";
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="col-md-4 mx-auto">

            <h3>Register</h3>

            <form method="post">
                <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>
                <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                <button name="register" class="btn btn-success w-100">Register</button>
            </form>

        </div>
    </div>

</body>

</html>