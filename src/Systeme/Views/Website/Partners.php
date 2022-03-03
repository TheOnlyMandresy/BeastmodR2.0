<?php
define('TEMPLATE', 'One');
define('PAGE', 'website-partners');
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="all">
    <?php foreach ($all as $data): ?>
    <div class="box-partner">
        <h2 class="head"><?= $data->name; ?></h2>

        <div class="infos">
            <img src="<?= $data->logo; ?>" />
            <p class="desc"><?= $data->description; ?></p>
            <p class="author">De <?= $data->author; ?></p>
            <div class="buttons-container">
                <a href="<?= $data->url; ?>" target="_blank" class="button-base">Leur site >></a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php $contentOne = ob_get_clean(); ?>