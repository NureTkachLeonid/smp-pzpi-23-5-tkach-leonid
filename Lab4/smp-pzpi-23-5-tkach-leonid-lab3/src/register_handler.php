<?php
// Логика регистрации
require_once __DIR__ . '/../config/db.php';

// Проверяем, что данные пришли методом POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Если не POST, перенаправляем на страницу регистрации
    header('Location: /register.php');
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    header('Location: /register.php?error=empty_fields');
    exit;
}

// Хэшируем пароль - это обязательно для безопасности!
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashed_password]);
    // После успешной регистрации перенаправляем на страницу входа
    header('Location: /login.php?success=registered');
    exit;
} catch (PDOException $e) {
    // 23000 - код ошибки SQL для нарушения уникальности (UNIQUE constraint)
    if ($e->getCode() == 23000) {
        header('Location: /register.php?error=username_taken');
        exit;
    }
    // Для других ошибок
    die("Ошибка при регистрации: " . $e->getMessage());
}