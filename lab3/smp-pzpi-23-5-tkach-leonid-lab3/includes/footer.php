<?php

if (!isset($navigation)) {
    $headerData = file_get_contents('../data/header_data.json');
    $navigation = json_decode($headerData, true);
}
?>

<div class="footer">
    <?php
    $first = true;
    foreach ($navigation['footer'] as $item):
        if (!$first):
            ?>
            <span class="separator">|</span>
        <?php
        endif;
        $first = false;
        ?>
        <a href="<?php echo $item['link']; ?>" class="nav-item">
            <?php echo $item['name']; ?>
        </a>
    <?php endforeach; ?>
</div>