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

// Display messages (e.g., "Product added to cart!")
if (isset($_SESSION['message'])) {
    echo '<div class="message success">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
if (isset($_SESSION['error'])) {
    echo '<div class="message error">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}

$cart_items = $_SESSION['cart'] ?? [];
$total_price = 0;
?>

<div class="container" style="padding: 2rem 0;">
    <h1 class="title title--center"><?= t('cart') ?></h1>
    <p style="text-align: center;"><?= t('cart_page_info') ?></p>

    <?php if (empty($cart_items)): ?>
        <div class="profile-card" style="margin-top: 2rem;">
            <p style="text-align: center;"><?= t('cart_empty') ?></p>
        </div>
    <?php else: ?>
        <div class="profile-card" style="margin-top: 2rem;">
            <h3 class="profile-card-title"><?= t('cart_items') ?></h3>
            <table class="table" style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;"><?= t('product_name_header') ?></th>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;"><?= t('price') ?></th>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;"><?= t('quantity') ?></th>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px; text-align: left;"><?= t('total') ?></th>
                        <th style="border-bottom: 1px solid #ddd; padding: 8px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $product_id => $item): ?>
                        <?php
                            $item_total = $item['price'] * $item['quantity'];
                            $total_price += $item_total;
                        ?>
                        <tr>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;"><?= htmlspecialchars($item['name']) ?></td>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;">$<?= number_format($item['price'], 2) ?></td>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;">
                                <form action="cart_handler.php" method="post" style="display: inline-flex; align-items: center;">
                                    <input type="hidden" name="action" value="update_quantity">
                                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                    <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" min="0" class="form-input" style="width: 60px; margin-right: 5px;" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;">$<?= number_format($item_total, 2) ?></td>
                            <td style="border-bottom: 1px solid #eee; padding: 8px;">
                                <form action="cart_handler.php" method="post" style="display: inline;">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                    <button type="submit" class="btn btn--small btn--danger"><?= t('remove') ?></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="border-top: 1px solid #ddd; padding: 8px; text-align: right;"><strong><?= t('total_cart_price') ?>:</strong></td>
                        <td colspan="2" style="border-top: 1px solid #ddd; padding: 8px;"><strong>$<?= number_format($total_price, 2) ?></strong></td>
                    </tr>
                </tfoot>
            </table>

            <div style="text-align: right; margin-top: 1.5rem;">
                <form action="cart_handler.php" method="post" style="display: inline;">
                    <input type="hidden" name="action" value="clear">
                    <button type="submit" class="btn btn--outlin btn--danger"><?= t('clear_cart') ?></button>
                </form>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="/products.php" class="btn"><?= t('continue_shopping') ?></a>
            <a href="/checkout.php" class="btn <?= empty($cart_items) ? 'btn--disabled' : '' ?>"><?= t('checkout') ?></a>        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>