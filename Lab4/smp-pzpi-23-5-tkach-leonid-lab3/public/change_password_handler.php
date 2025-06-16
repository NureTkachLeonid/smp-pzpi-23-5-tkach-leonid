<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /login.php');
    exit;
}

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
    header('Location: /change_password.php?error=empty_fields');
    exit;
}

if ($new_password !== $confirm_password) {
    header('Location: /change_password.php?error=passwords_do_not_match');
    exit;
}

if (strlen($new_password) < 6) {
    header('Location: /change_password.php?error=password_too_short');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($current_password, $user['password'])) {
        header('Location: /change_password.php?error=wrong_password');
        exit;
    }

    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $update_stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update_stmt->execute([$new_hashed_password, $_SESSION['user_id']]);

    header('Location: /change_password.php?success=password_updated');
    exit;

} catch (PDOException $e) {
    die("Ошибка базы данных: " . $e->getMessage());
}