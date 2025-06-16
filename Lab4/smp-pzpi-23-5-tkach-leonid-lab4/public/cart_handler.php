<?php
session_start(); // Start the session to access $_SESSION

// Ensure the cart is initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
            $product_name = filter_var($_POST['product_name'], FILTER_SANITIZE_STRING);
            $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $quantity = filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT);

            if ($product_id && $product_name && $price && $quantity > 0) {
                // Check if product already exists in cart
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$product_id] = [
                        'name' => $product_name,
                        'price' => $price,
                        'quantity' => $quantity,
                    ];
                }
                $_SESSION['message'] = 'Product added to cart!'; // Optional: for user feedback
            } else {
                $_SESSION['error'] = 'Invalid product data.';
            }
            break;

        case 'remove':
            $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
            if (isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);
                $_SESSION['message'] = 'Product removed from cart!';
            }
            break;

        case 'update_quantity':
            $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
            $new_quantity = filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT);
            if (isset($_SESSION['cart'][$product_id]) && $new_quantity >= 0) {
                if ($new_quantity == 0) {
                    unset($_SESSION['cart'][$product_id]);
                    $_SESSION['message'] = 'Product removed from cart!';
                } else {
                    $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
                    $_SESSION['message'] = 'Cart quantity updated!';
                }
            }
            break;

        case 'clear':
            $_SESSION['cart'] = [];
            $_SESSION['message'] = 'Cart cleared!';
            break;
    }
}

// Redirect back to the cart or products page
if (isset($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: /cart.php'); // Default redirect if HTTP_REFERER is not set
}
exit;