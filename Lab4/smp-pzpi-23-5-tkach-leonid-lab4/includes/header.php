<?php
// Запускаем сессию в самом начале
session_start();

// Подключаем логику для работы с языками
require_once __DIR__ . '/../config/language.php';
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'ua' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= t('page_title') ?></title>
    <link rel="icon" href="/icons/favicon-color.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a href="/" class="site-logo">
                <div class="logo-icon-wrapper">
                    <?php include __DIR__ . '/../public/icons/nut.svg'; ?>
                </div>
                <span class="logo-text"><?= t('page_title') ?></span>
            </a>
            <nav>


                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/products.php" class="btn btn--outline" title="<?= t('products') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/><path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/><path d="m2.1 21.8 6.4-6.3"/><path d="m19 5-7 7"/></svg>
                        <span><?= t('products') ?></span>
                    </a>
                    <a href="/cart.php" class="btn btn--outline" title="<?= t('cart') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 11-1 9"/><path d="m19 11-4-7"/><path d="M2 11h20"/><path d="m3.5 11 1.6 7.4a2 2 0 0 0 2 1.6h9.8a2 2 0 0 0 2-1.6l1.7-7.4"/><path d="M4.5 15.5h15"/><path d="m5 11 4-7"/><path d="m9 11 1 9"/></svg>
                        <span><?= t('cart') ?></span>
                    </a>
                <?php else: ?>
                    <a href="/login.php" class="btn btn--outline"><?= t('login') ?></a>
                    <a href="/register.php" class="btn btn--outline"><?= t('register') ?></a>
                <?php endif; ?>

                <div class="lang-dropdown">
                    <button class="lang-dropdown-btn" id="langBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.54 15H17a2 2 0 0 0-2 2v4.54"/><path d="M7 3.34V5a3 3 0 0 0 3 3a2 2 0 0 1 2 2c0 1.1.9 2 2 2a2 2 0 0 0 2-2c0-1.1.9-2 2-2h3.17"/><path d="M11 21.95V18a2 2 0 0 0-2-2a2 2 0 0 1-2-2v-1a2 2 0 0 0-2-2H2.05"/><circle cx="12" cy="12" r="10"/></svg>
                    </button>
                    <div class="lang-dropdown-content" id="langDropdownContent">
                        <a href="?lang=ua" class="<?= ($_SESSION['lang'] == 'ua') ? 'active' : '' ?>">Українська</a>
                        <a href="?lang=en" class="<?= ($_SESSION['lang'] == 'en') ? 'active' : '' ?>">English</a>
                    </div>
                </div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/profile.php" class="btn btn--outline" title="<?= t('profile') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20a6 6 0 0 0-12 0"/><circle cx="12" cy="10" r="4"/><circle cx="12" cy="12" r="10"/></svg>
                        <span><?= t('profile') ?></span>
                    </a>
                <?php endif; ?>
                
            </nav>
        </div>
    </header>
    <main class="main-content">