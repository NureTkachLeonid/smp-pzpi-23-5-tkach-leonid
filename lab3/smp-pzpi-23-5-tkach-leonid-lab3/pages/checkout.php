<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$pageTitle = 'Checkout - Web Store';
$additionalStyles = '
    .checkout-container {
        width: 100%;
        max-width: 800px;
    }
    
    .success-message {
        text-align: center;
        padding: 30px;
        background-color: #f8f8f8;
        border-radius: 15px;
        margin-top: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .checkout-actions {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
';
include '../includes/header.php';
?>
    <div class="content">
        <div class="checkout-container">
            <h2>Order Confirmation</h2>

            <?php
            $_SESSION['cart'] = [];
            ?>

            <div class="success-message">
                <h3>Thank you for your order!</h3>
                <p>Your order has been successfully placed.</p>
                <p>This is a demonstration website, so no actual order has been processed.</p>

                <div class="checkout-actions">
                    <a href="products.php" class="btn btn-checkout">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>

<?php
include '../includes/footer.php';
?>