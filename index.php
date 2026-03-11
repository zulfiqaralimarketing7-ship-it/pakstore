<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PakStore — Modern E-Commerce</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <!-- HEADER -->
    <?php session_start(); ?>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">PakStore</a>

            <>
                <?php if (isset($_SESSION['user_id'])) { ?>

                    <span class="text-white me-3">
                        👋 <?= $_SESSION['user_name'] ?>
                    </span>

                    <a href="logout.php" class="btn btn-danger btn-sm">
                        Logout
                    </a>

                <?php } else { ?>

                    <a href="login.php" class="btn btn-light btn-sm">Login</a>
                    <a href="register.php" class="btn btn-warning btn-sm">Register</a>

                <?php } ?>
                <a href="cart.php" class="btn btn-warning btn-sm">Cart</a>
            </div>
        </div>
    </nav>
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success text-center m-0">
            <?= $_SESSION['success']; ?>
        </div>
    <?php unset($_SESSION['success']);
    } ?>
    <!-- HERO -->
    <section class="hero">
        <div class="container text-center">
            <h1>Pakistan’s #1 Online Store</h1>
            <p>Shop Smart — Shop Fast — Shop PakStore</p>
            <a href="products.php" class="btn btn-warning btn-lg">Shop Now</a>
        </div>
    </section>

    <!-- CATEGORIES -->
    <section class="container my-5">
        <h3 class="mb-4">Top Categories</h3>
        <div class="row g-4">

            <div class="col-md-3">
                <div class="cat-card">Electronics</div>
            </div>

            <div class="col-md-3">
                <div class="cat-card">Mobiles</div>
            </div>

            <div class="col-md-3">
                <div class="cat-card">Fashion</div>
            </div>

            <div class="col-md-3">
                <div class="cat-card">Grocery</div>
            </div>

        </div>
    </section>

    <!-- PRODUCTS -->
    <section class="container my-5">
        <h3 class="mb-4">Featured Products</h3>

        <div class="row g-4">

            <div class="row" id="product-list"></div>

            <div class="row">
                <?php for ($i = 1; $i <= 8; $i++) { ?>
                    <div class="col-md-3">
                        <div class="product-card">
                            <img src="Gemini_Generated_Image_6ii3j06ii3j06ii3.png" class="img-fluid">

                            <h5>Product <?= $i ?></h5>
                            <p>Rs. <?= $price = rand(999, 9999) ?></p>

                            <form action="cart.php" method="POST">
                                <input type="hidden" name="id" value="<?= $i ?>">
                                <input type="hidden" name="name" value="Product <?= $i ?>">
                                <input type="hidden" name="price" value="<?= $price ?>">
                                <input type="hidden" name="image" value="Gemini_Generated_Image_6ii3j06ii3j06ii3.png">

                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-sm">
                                    Add to Cart
                                </button>

                                <a href="product_details.php?id=<?= $i ?>" class="btn btn-outline-primary btn-sm">
                                    View Details
                                </a>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-dark text-light text-center p-3">
        © 2026 PakStore — Professional E-Commerce Platform
    </footer>

</body>

</html>