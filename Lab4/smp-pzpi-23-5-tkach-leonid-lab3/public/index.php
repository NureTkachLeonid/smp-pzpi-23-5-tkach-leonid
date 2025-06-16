<?php require_once __DIR__ . '/../includes/header.php'; ?>

<main class="page-content">

<section class="hero-section">
        <div class="container">
            <div class="hero-content">

                <div class="hero-column-left">
                    <h1 class="hero-title">
                        <span class="hero-title-accent" style="display: flex; flex-direction: row;"><?= t('hero_accent') ?></span>
                        <?= t('hero_title') ?>
                    </h1>
                </div>

                <div class="hero-column-right">
                    <p class="hero-subheading"><?= t('hero_subtitle') ?></p>
                    <a href="/register.php" class="btn"><?= t('join_us') ?></a>
                </div>
                
            </div>
        </div>
    </section>

    <section class="info-section">
        <div class="container">
            <h2 class="title title--center"><?= t('our_philosophy_title') ?></h2>
            <p class="info-text">
                <?= t('our_philosophy_text') ?>
            </p>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <div class="feature-item">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1643553110265-e76e397643a5" alt="Молочные продукты">
                </div>
                <div class="feature-content">
                    <h3 class="title"><?= t('dairy_title') ?></h3>
                    <p><?= t('dairy_text') ?></p>
                </div>
            </div>
            
            <div class="feature-item feature-item--reversed">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff" alt="Ремесленный хлеб">
                </div>
                <div class="feature-content">
                    <h3 class="title"><?= t('bread_title') ?></h3>
                    <p><?= t('bread_text') ?></p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1557844352-761f2565b576" alt="Сезонные овощи и фрукты">
                </div>
                <div class="feature-content">
                    <h3 class="title"><?= t('veg_title') ?></h3>
                    <p><?= t('veg_text') ?></p>
                </div>
            </div>
            </div>
    </section>

</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>