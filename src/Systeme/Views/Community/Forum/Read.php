<?php
define('TEMPLATE', 'Three');
define('PAGE', 'community-forum-read');
?>

<?php ob_start(); ?>

<div class="box-header" style="background-image: url('<?= $data->background; ?>');">
    <?php require_once Systeme::root(1). 'HTML/Forum/Header.php'; ?>
</div>

<?php $contentTop = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="infos divided-2-forced">
    <?php require_once Systeme::root(1). 'HTML/Forum/Infos.php'; ?>
</div>

<div class="box-content margin">
    <div class="content"><?= $data->content; ?></div>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="comments margin">
    <?php require_once Systeme::root(1). 'HTML/Forum/Comments.php'; ?>
</div>

<?php $contentRight = ob_get_clean(); ?>