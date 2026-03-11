<?php
session_start();
include "db.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['success'] = "Login Successful!";

            header("Location: index.php");
            exit;
        } else {
            $error = "Wrong Password!";
        }
    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', sans-serif;
    }

    .login-box {
        width: 100%;
        max-width: 420px;
        background: rgba(255, 255, 255, .05);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 0 40px rgba(0, 0, 0, .6);
        color: white;
    }

    .login-box h3 {
        font-weight: 600;
        margin-bottom: 25px;
        text-align: center;
    }

    .form-control {
        background: rgba(255, 255, 255, .1);
        border: none;
        color: white;
    }

    .form-control:focus {
        background: rgba(255, 255, 255, .15);
        color: white;
        box-shadow: none;
    }

    .btn-login {
        background: #00c6ff;
        border: none;
        font-weight: 600;
    }

    .brand {
        font-size: 26px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 10px;
        color: #00c6ff;
    }
</style>

<body class="bg-light">

    <div class="container py-5">
        <div class="col-md-4 mx-auto">

            <h3>Login</h3>

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php } ?>

            <form method="post">
                <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                <button name="login" class="btn btn-primary w-100">Login</button>
            </form>

        </div>
    </div>

</body>

</html>