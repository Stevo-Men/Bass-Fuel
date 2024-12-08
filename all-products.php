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

    $products = [];
    

    $query = "select * from product";
    $result = pg_query($conn, $query);
    if (!$result) {
        echo "DB query: " . pg_last_error();
        exit;
    }

    $types = [];
    while ($row = pg_fetch_assoc($result)) {
        $products[] = $row;
    }

    // $pokemon = pg_fetch_assoc($result);
    // $formattedId = str_pad($pokemon["id"], 3, "0", STR_PAD_LEFT);

    pg_close($conn);
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Bass Fuel Products</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
         <!-- Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Megrim&display=swap" rel="stylesheet">
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="./public/stylesheets/vendor/shop-homepage-template.css" rel="stylesheet"/>
        <link href="./public/stylesheets/styles.css" rel="stylesheet">
        <script type="module" src="./public/javascripts/app.js"></script>
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
                                <li><a class="dropdown-item" href="all-prodcuts.php">All Products</a></li>
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
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">All of our products</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Navigate through our variety of musical hardwares!</p>
                </div>
            </div>
        </header>
        <!-- Section--> 
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php if (empty($products)): ?>
                        <p>No products available at the moment.</p>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col mb-5">
                                <div class="card h-100">
                                    <a href="/product_details.php?product_id=<?= $product['product_id'] ?>" style="text-decoration: none; color: inherit;">
                                        <img class="card-img-top" src="<?= htmlspecialchars($product['image_url']) ?: 'default_image.jpg'; ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
                                        <div class="card-body p-4">
                                            <div class="text-center">
                                                <h5 class="fw-bolder"><?= htmlspecialchars($product['name']) ?></h5>
                                                <p>$<?= number_format($product['price'], 2) ?></p>
                                                <p><?= htmlspecialchars(substr($product['description'], 0, 100)) ?>...</p>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <a class="btn btn-outline-dark mt-auto" href="cart.php?product_id=<?= $product['product_id'] ?>">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>



        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
