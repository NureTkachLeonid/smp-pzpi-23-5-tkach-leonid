<?php
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$order_id = filter_var($_GET['order_id'] ?? null, FILTER_SANITIZE_NUMBER_INT);

if (!$order_id) {
    echo json_encode(['error' => 'Invalid order ID']);
    exit;
}

try {
    // First, verify that the order belongs to the logged-in user
    $verify_stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE id = ? AND user_id = ?");
    $verify_stmt->execute([$order_id, $_SESSION['user_id']]);
    if ($verify_stmt->fetchColumn() === 0) {
        echo json_encode(['error' => 'Order not found or does not belong to user']);
        exit;
    }

    // Then, fetch the items for that order
    $items_stmt = $pdo->prepare("SELECT product_name, quantity, price_at_purchase FROM order_items WHERE order_id = ?");
    $items_stmt->execute([$order_id]);
    $order_items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($order_items);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit;
}