<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container my-5">
        <h1 class="mb-4">Paiement</h1>
        <div id="cart-items" class="mb-4">
            <h2>Produits dans votre panier :</h2>
            <ul id="product-list" class="list-group"></ul>
        </div>
        <form id="payment-form" action="process_payment.php" method="POST">
            <h2>Informations de paiement</h2>
            <div class="mb-3">
                <label for="first_name" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Courriel</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <small id="email-error" class="text-danger d-none">Ce courriel existe déjà.</small>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Pays</label>
                <input type="text" class="form-control" id="country" name="country" required>
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Rue</label>
                <input type="text" class="form-control" id="street" name="street" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">Ville</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="mb-3">
                <label for="postal_code" class="form-label">Code Postal</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" required>
            </div>
            <input type="hidden" name="cart_data" id="cart_data">
            <button type="submit" class="btn btn-primary">Passer la commande</button>
        </form>
    </div>

    <!-- JavaScript to retrieve products from localStorage -->
    <script>
        // Retrieve cart items from localStorage
        const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
        const productList = document.getElementById('product-list');
        const cartDataInput = document.getElementById('cart_data');

        if (cartItems.length === 0) {
            productList.innerHTML = '<li class="list-group-item">Votre panier est vide.</li>';
        } else {
            cartItems.forEach(item => {
                const li = document.createElement('li');
                li.classList.add('list-group-item');
                li.textContent = `${item.name} - $${item.price} x ${item.quantity}`;
                productList.appendChild(li);
            });

            // Store cart data in hidden input for form submission
            cartDataInput.value = JSON.stringify(cartItems);
        }

        // Check email availability in real-time
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('email-error');
        emailInput.addEventListener('blur', async () => {
            const response = await fetch('check_email.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: emailInput.value })
            });
            const data = await response.json();
            if (data.exists) {
                emailError.classList.remove('d-none');
            } else {
                emailError.classList.add('d-none');
            }
        });
    </script>
</body>

</html>
