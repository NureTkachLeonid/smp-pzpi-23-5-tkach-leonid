<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    exit('Access denied');
}

$username = $_POST['username'] ?? null;
$description = $_POST['description'] ?? null;

if ($username) {
    $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->execute([$username, $_SESSION['user_id']]);
    $_SESSION['username'] = $username;
}

if ($description !== null) {
    $stmt = $pdo->prepare("UPDATE users SET description = ? WHERE id = ?");
    $stmt->execute([$description, $_SESSION['user_id']]);
}

header('Location: /profile.php');
exit;