<?php
// Database connection
$host = getenv("DB_HOSTNAME");
$port = "5432";
$databaseName = getenv("DB_NAME");
$username = getenv("DB_USERNAME");
$password = getenv("DB_PASSWORD");
$connectionString = "host=$host port=$port dbname=$databaseName user=$username password=$password";

$conn = pg_connect($connectionString);
if (!$conn) {
    die("Error connecting to database: " . pg_last_error());
}

// Get the product ID from the query string
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

if ($product_id <= 0) {
    die("Invalid product ID.");
}

// Fetch the product details
$query = "SELECT * FROM product WHERE product_id = $product_id";
$result = pg_query($conn, $query);

if (!$result) {
    die("Error fetching product details: " . pg_last_error());
}

$product = pg_fetch_assoc($result);

if (!$product) {
    die("Product not found.");
}

// Close the database connection
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Product Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4"><?= htmlspecialchars($product['name']) ?></h1>
        <div class="row">
            <div class="col-md-6">
                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid" />
            </div>
            <div class="col-md-6">
                <h3>Price: $<?= number_format($product['price'], 2) ?></h3>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <a href="cart.php?product_id=<?= $product['product_id'] ?>" class="btn btn-primary">Add to Cart</a>
                <a href="all-products.php" class="btn btn-secondary">Back to Products</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
