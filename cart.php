<?php
session_start();

// Database connection
$host = getenv("DB_HOSTNAME");
$port = "5432";
$databaseName = getenv("DB_NAME");
$username = getenv("DB_USERNAME");
$password = getenv("DB_PASSWORD");
$connectionString = "host=$host port=$port dbname=$databaseName user=$username password=$password";

$conn = pg_connect($connectionString);
if (!$conn) {
    echo "Error connecting to database: " . pg_last_error();
    exit;
}

// Initialize cart session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id']; // Ensure product ID is numeric
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1; // Default quantity
    } else {
        $_SESSION['cart'][$product_id]++;
    }
    header("Location: cart.php");
    exit;
}

// Update quantities or remove items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$product_id]); // Remove item
        } else {
            $_SESSION['cart'][$product_id] = (int)$quantity; // Update quantity
        }
    }
}

// Retrieve cart items
$cart_products = [];
if (!empty($_SESSION['cart'])) {
    // Create a comma-separated list of product IDs
    $product_ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
    
    // Update the query to use `product_id`
    $query = "SELECT * FROM product WHERE product_id IN ($product_ids)";
    $result = pg_query($conn, $query);
    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            // Add quantity from the session to the product data
            $row['quantity'] = $_SESSION['cart'][$row['product_id']];
            $cart_products[] = $row;
        }
    } else {
        error_log("Database query error: " . pg_last_error());
    }
} else {
    // Cart is empty
    $cart_products = [];
}

// Close connection
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>My Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Bass Fuel</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="cart.php">Cart</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Section -->
    <div class="container my-5">
        <h1 class="mb-4">Your Cart</h1>
        <?php if (empty($cart_products)): ?>
            <p>Your cart is empty. <a href="index.php">Start shopping!</a></p>
        <?php else: ?>
            <form method="POST" action="cart.php">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($cart_products as $product):
                            $subtotal = $product['price'] * $product['quantity'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td>$<?= number_format($product['price'], 2) ?></td>
                                <td>
                                    <input type="number" name="quantities[<?= $product['product_id'] ?>]" value="<?= $product['quantity'] ?>" min="0" class="form-control" />
                                </td>
                                <td>$<?= number_format($subtotal, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong>$<?= number_format($total, 2) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
                    <button type="submit" class="btn btn-primary">Update Cart</button>
                </div>
            </form>
        <?php endif; ?>
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
