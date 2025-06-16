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

$cart_items = $_SESSION['cart'] ?? [];
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<div class="container" style="padding: 2rem 0;">
    <h1 class="title title--center"><?= t('checkout_title') ?></h1>
    <p style="text-align: center;"><?= t('checkout_page_info') ?></p>

    <?php if (empty($cart_items)): ?>
        <div class="profile-card" style="margin-top: 2rem;">
            <p style="text-align: center;"><?= t('cart_empty') ?></p>
            <p style="text-align: center;"><a href="/products.php" class="btn"><?= t('continue_shopping') ?></a></p>
        </div>
    <?php else: ?>
        <div class="profile-card" style="margin-top: 2rem;">
            <h3 class="profile-card-title"><?= t('order_summary') ?></h3>
            <table class="table" style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;"><?= t('product_name_header') ?></th>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;"><?= t('quantity') ?></th>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;"><?= t('price') ?></th>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;"><?= t('total') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $product_id => $item): ?>
                        <tr>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;"><?= htmlspecialchars($item['name']) ?></td>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;"><?= htmlspecialchars($item['quantity']) ?></td>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;">$<?= number_format($item['price'], 2) ?></td>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="border-top: 1px solid #ddd; padding: 8px; text-align: right;"><strong><?= t('total_cart_price') ?>:</strong></td>
                        <td style="border-top: 1px solid #ddd; padding: 8px;"><strong>$<?= number_format($total_price, 2) ?></strong></td>
                    </tr>
                </tfoot>
            </table>

            <div style="text-align: center; margin-top: 2rem;">
                <a href="/cart.php" class="btn btn--outlin"><?= t('back_to_cart') ?></a>
                <form action="/place_order_handler.php" method="post" style="display: inline;">
                    <button type="submit" class="btn"><?= t('place_order') ?></button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>