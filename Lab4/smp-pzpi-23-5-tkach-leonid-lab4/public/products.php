<?php
require_once __DIR__ . '/../includes/header.php';

// Protect the page: if the user is NOT logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// Start the session if not already started (header.php should handle this, but good to be sure)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize the cart in session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>

<div class="container" style="padding: 2rem 0;">
    <h1 class="title title--center"><?= t('products') ?></h1>
    <p style="text-align: center;"><?= t('products_page_info') ?></p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-top: 2rem;">
        <div class="profile-card">
            <form action="cart_handler.php" method="post">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="1">
                <input type="hidden" name="product_name" value="<?= t('product_dairy_title') ?>">
                <input type="hidden" name="price" value="5.99">

                <h3 class="profile-card-title"><?= t('product_dairy_title') ?></h3>
                <p><?= t('product_dairy_description') ?></p>
                <p><strong><?= t('price') ?>: $5.99</strong></p>
                <input type="number" name="quantity" value="1" min="1" class="form-input" style="width: 100px; margin-bottom: 1rem;">
                <button type="submit" class="btn btn--block"><?= t('add_to_cart') ?></button>
            </form>
        </div>

        <div class="profile-card">
            <form action="cart_handler.php" method="post">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="2">
                <input type="hidden" name="product_name" value="<?= t('product_bread_title') ?>">
                <input type="hidden" name="price" value="3.49">

                <h3 class="profile-card-title"><?= t('product_bread_title') ?></h3>
                <p><?= t('product_bread_description') ?></p>
                <p><strong><?= t('price') ?>: $3.49</strong></p>
                <input type="number" name="quantity" value="1" min="1" class="form-input" style="width: 100px; margin-bottom: 1rem;">
                <button type="submit" class="btn btn--block"><?= t('add_to_cart') ?></button>
            </form>
        </div>

        <div class="profile-card">
            <form action="cart_handler.php" method="post">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="3">
                <input type="hidden" name="product_name" value="<?= t('product_veg_title') ?>">
                <input type="hidden" name="price" value="7.29">

                <h3 class="profile-card-title"><?= t('product_veg_title') ?></h3>
                <p><?= t('product_veg_description') ?></p>
                <p><strong><?= t('price') ?>: $7.29</strong></p>
                <input type="number" name="quantity" value="1" min="1" class="form-input" style="width: 100px; margin-bottom: 1rem;">
                <button type="submit" class="btn btn--block"><?= t('add_to_cart') ?></button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>