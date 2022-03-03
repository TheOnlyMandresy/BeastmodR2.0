<?php
define('TEMPLATE', 'One');
define('PAGE', 'others-games');
?>


<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="all">
    <?php foreach ($all as $data): ?>
    <div class="box-game">
        <h2 class="head"><?= $data->name; ?></h2>

        <div class="infos">
            <p class="desc"><?= $data->description; ?></p>
            <p class="author">De <?= $data->username; ?></p>
            <div class="buttons-container">
                <a href="<?= $data->url; ?>" target="_blank" class="button-success">Go >></a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php $contentOne = ob_get_clean(); ?>