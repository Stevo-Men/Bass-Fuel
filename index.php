Updated Homepage with Product Slideshow

<?php
    $host = getenv("DB_HOSTNAME");
    $port = "5432";
    $databaseName = getenv("DB_NAME");
    $username = getenv("DB_USERNAME");
    $password = getenv("DB_PASSWORD");
    $connectionString = "host=$host port=$port dbname=$databaseName user=$username password=$password";

    $conn = pg_connect($connectionString);
    if (!$conn) {
        echo "Error connecting to database: " . pg_last_error();
    }

    // Get the top 5 most expensive products
    $query = "SELECT * FROM product ORDER BY price DESC LIMIT 5";
    $result = pg_query($conn, $query);
    if (!$result) {
        echo "DB query: " . pg_last_error();
        exit;
    }

    $topProducts = [];
    while ($row = pg_fetch_assoc($result)) {
        $topProducts[] = $row;
    }

    pg_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Bass Fuel Home</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Megrim&display=swap" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="./public/stylesheets/vendor/shop-homepage-template.css" rel="stylesheet" />
    <link rel="stylesheet" href="./public/stylesheets/styles.css">
    <!-- Add Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <script type="module" src=".//slideshow.js"></script>
</head>
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Bass Fuel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="all-products.php">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                            <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Slideshow Section -->
    <div class="swiper-container">
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php foreach ($topProducts as $product): ?>
                <div class="swiper-slide">
                    <img src="<?php echo htmlspecialchars($product['image_url'] ?? 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>" />
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Details</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>


    <!-- Featured Products Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="text-center mb-5">Featured Products</h2>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <!-- Your existing product cards here -->
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2024</p></div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <!-- Initialize Swiper -->
    <script>
     
    </script>
</body>
</html>