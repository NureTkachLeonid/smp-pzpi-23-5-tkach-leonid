<?php
require_once __DIR__ . '/../includes/header.php';
// Проверяем, авторизован ли пользователь.
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
?>

<div class="container" style="padding: 2rem 0;">
    <h1 class="title"><?= t('dashboard') ?></h1>
    <p><?= sprintf(t('dashboard_greeting'), htmlspecialchars($_SESSION['username'])) ?></p>
    <p><?= t('dashboard_info') ?></p>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>