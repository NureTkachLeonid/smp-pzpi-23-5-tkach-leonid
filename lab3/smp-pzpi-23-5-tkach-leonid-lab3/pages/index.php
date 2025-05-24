<?php

$pageTitle = 'Home - Web Store';
$additionalStyles = '
    .welcome {
        text-align: center;
        max-width: 800px;
    }
    
    .welcome h1 {
        margin-bottom: 20px;
    }
    
    .welcome p {
        line-height: 1.6;
        margin-bottom: 20px;
    }
    
    .shop-now-btn {
        display: inline-block;
        margin-top: 20px;
    }
';
include '../includes/header.php';
?>
    <div class="content">
        <div class="welcome">
            <h1>Welcome to Our Web Store</h1>
            <p>This is a simple web store created as a student project. You can browse our products and add them to your shopping cart.</p>
            <a href="products.php" class="btn shop-now-btn">Shop Now</a>
        </div>
    </div>

<?php
include '../includes/footer.php';
?>