<?php
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">

    <section class="about-section">
        <h1 class="title title--center"><?= t('about_us_title') ?></h1>
        <p class="about-text">
            <?= t('about_us_main_text') ?>
        </p>
    </section>

    <section class="team-section">
        <h2 class="title title--center"><?= t('our_team_title') ?></h2>
        <div class="team-grid">
            
            <div class="team-member-card">
                <img src="https://images.unsplash.com/photo-1697498435309-2c7864cfd607" alt="<?= t('team_member_1_name') ?>" class="team-member-avatar">
                <h3 class="team-member-name"><?= t('team_member_1_name') ?></h3>
                <p class="team-member-role"><?= t('team_member_1_role') ?></p>
                <p class="team-member-group"><?= t('team_member_1_group') ?></p>
            </div>
            
            <div class="team-member-card">
                <img src="https://digi-con.org/wp-content/uploads/2024/12/alex-shuper-xWi-0KaEAQk-unsplash-scaled.jpg" alt="<?= t('team_member_2_name') ?>" class="team-member-avatar">
                <h3 class="team-member-name"><?= t('team_member_2_name') ?></h3>
                <p class="team-member-role"><?= t('team_member_2_role') ?></p>
                <p class="team-member-group"><?= t('team_member_2_dept') ?></p>
            </div>

        </div>
    </section>

    <section class="contact-section">
        <div class="contact-card">
            <h2 class="profile-card-title"><?= t('contact_info_title') ?></h2>
            <div class="contact-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/></svg>
                <span>Email: <a href="mailto:leonid.tkach@nure.ua"><?= t('contact_email') ?></a></span>
            </div>
            <div class="contact-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 21v-3a2 2 0 0 0-4 0v3"/><path d="M18 12h.01"/><path d="M18 16h.01"/><path d="M22 7a1 1 0 0 0-1-1h-2a2 2 0 0 1-1.143-.359L13.143 2.36a2 2 0 0 0-2.286-.001L6.143 5.64A2 2 0 0 1 5 6H3a1 1 0 0 0-1 1v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2z"/><path d="M6 12h.01"/><path d="M6 16h.01"/><circle cx="12" cy="10" r="2"/></svg>
                <span><?= t('institution_label') ?>: <?= t('institution_name') ?></span>
            </div>
        </div>
    </section>

</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>