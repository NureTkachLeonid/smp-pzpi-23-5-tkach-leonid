<?php
require_once __DIR__ . '/../includes/header.php'; // Подключаем хедер (он сам запустит сессию)

// Если пользователь уже вошел, перенаправляем
if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard.php');
    exit;
}
?>
<div class="form-container">
    <div style="display: flex; flex-direction: column; gap: 8px;">
        <h2 class="title title--center"><?= t('form_login_title') ?></h2>
        
        <form action="/login_handler.php" method="post">
            <?php
                if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials') {
                    echo '<p class="message message--error">' . t('error_invalid_credentials') . '</p>';
                }
                if (isset($_GET['success']) && $_GET['success'] == 'registered') {
                    echo '<p class="message message--success">' . t('success_registered') . '</p>';
                }
            ?>
            
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="username" class="label"><?= t('username') ?></label>
                        <input type="text" id="username" name="username" required class="input input--block">
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="password" class="label"><?= t('password') ?></label>
                        <input type="password" id="password" name="password" required class="input input--block">
                    </div>
                </div>
                
                <button type="submit" class="btn "><?= t('button_login') ?></button>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>