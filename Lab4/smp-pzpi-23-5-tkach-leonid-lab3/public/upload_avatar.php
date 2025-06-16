<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit('Access denied');
}

if (isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '-' . basename($file['name']);
        $uploadPath = $uploadDir . $fileName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($file['type'], $allowedTypes) && $file['size'] < 5000000) { // 5MB limit
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $webPath = '/uploads/avatars/' . $fileName;

                $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
                $stmt->execute([$webPath, $_SESSION['user_id']]);

                header('Location: /profile.php');
                exit;
            }
        }
    }
}
header('Location: /profile.php?error=upload_failed');
exit;