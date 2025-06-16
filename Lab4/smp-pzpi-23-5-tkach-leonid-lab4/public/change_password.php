<?php
require_once __DIR__ . '/../includes/header.php'; // Подключаем хедер (он сам запустит сессию)

// Защищаем страницу: если пользователь НЕ вошел, перенаправляем на главную
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
?>
<div class="form-container">
    <div style="display: flex; flex-direction: column; gap: 8px;">
        <h2 class="title title--center"><?= t('form_change_password_title') ?></h2>
        
        <form action="/change_password_handler.php" method="post">
            <?php
                // Блок для отображения сообщений об успехе или ошибках
                if (isset($_GET['error'])) {
                    $error_key = 'error_' . $_GET['error'];
                    echo '<p class="message message--error">' . t($error_key) . '</p>';
                }
                if (isset($_GET['success']) && $_GET['success'] == 'password_updated') {
                    echo '<p class="message message--success">' . t('success_password_updated') . '</p>';
                }
            ?>
            
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="current_password" class="label"><?= t('current_password') ?></label>
                        <input type="password" id="current_password" name="current_password" required class="input input--block">
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="new_password" class="label"><?= t('new_password') ?></label>
                        <input type="password" id="new_password" name="new_password" required class="input input--block">
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <label for="confirm_password" class="label"><?= t('confirm_password') ?></label>
                        <input type="password" id="confirm_password" name="confirm_password" required class="input input--block">
                    </div>

                </div>
                
                <button type="submit" class="btn "><?= t('button_change_password') ?></button>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>