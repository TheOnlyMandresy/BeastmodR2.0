<?php
define('TEMPLATE', 'Three');
define('PAGE', 'others-events');

?>

<?php ob_start(); ?>

<div class="box-title" style="background-image: url(<?= $data->background; ?>);">
    <h1><?= $data->title; ?></h1>
</div>

<?php $contentTop = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box-infos">
    <?php require_once Systeme::root(1). 'HTML/Events/Infos.php'; ?>
</div>

<div class="box-content">
    <?= $data->content; ?>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box-rewards">
    <?php require_once Systeme::root(1). 'HTML/Events/Rewards.php'; ?>
</div>

<?php $contentRight = ob_get_clean(); ?>