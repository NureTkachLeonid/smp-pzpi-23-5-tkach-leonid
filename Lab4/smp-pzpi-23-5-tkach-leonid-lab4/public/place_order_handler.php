<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Ensure user is logged in and request is POST
if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_items = $_SESSION['cart'] ?? [];

if (empty($cart_items)) {
    $_SESSION['error'] = 'Your cart is empty. Cannot place an empty order.';
    header('Location: /cart.php');
    exit;
}

$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

try {
    $pdo->beginTransaction();

    // 1. Insert into orders table
    $stmt_order = $pdo->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $stmt_order->execute([$user_id, $total_price]);
    $order_id = $pdo->lastInsertId();

    // 2. Insert into order_items table for each product in the cart
    $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price_at_purchase) VALUES (?, ?, ?, ?, ?)");
    foreach ($cart_items as $product_id => $item) {
        $stmt_item->execute([
            $order_id,
            $product_id, // Assuming product_id from your cart is unique for each product
            $item['name'],
            $item['quantity'],
            $item['price']
        ]);
    }

    $pdo->commit();

    // Clear the cart after successful order placement
    $_SESSION['cart'] = [];
    $_SESSION['message'] = 'Your order has been placed successfully!';
    header('Location: /profile.php'); // Redirect to profile to show purchase history
    exit;

} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['error'] = 'There was an error placing your order: ' . $e->getMessage();
    header('Location: /checkout.php');
    exit;
}