<?php
// Проверяем, был ли отправлен запрос методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Если да, то это попытка регистрации. Подключаем обработчик.
    require_once __DIR__ . '/../src/register_handler.php';
    exit;
}

// Если это GET-запрос, показываем страницу.
require_once __DIR__ . '/../includes/header.php';
// Если пользователь уже вошел в систему, перенаправляем его на дашборд
if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard.php');
    exit;
}
?>
<div class="form-container">
    <div style="display: flex; flex-direction: column; gap: 8px;">
        
        <h2 class="title title--center"><?= t('form_register_title') ?></h2>
        
        <form action="/register.php" method="post">
            <?php
                if (isset($_GET['error'])) {
                    $error_key = '';
                    if ($_GET['error'] == 'username_taken') {
                        $error_key = 'error_username_taken';
                    } elseif ($_GET['error'] == 'empty_fields') {
                        $error_key = 'error_empty_fields';
                    }
                    if ($error_key) {
                        echo '<p class="message message--error">' . t($error_key) . '</p>';
                    }
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
            
                <button type="submit" class="btn "><?= t('button_register') ?></button>
            </div>
        </form>

    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>