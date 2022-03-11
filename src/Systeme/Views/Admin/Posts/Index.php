<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-posts-index');
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box-posts margin">
    <?php require_once Systeme::root(1). 'HTML/Admin/Posts/All.php'; ?>
</div>

<?php require_once Systeme::root(1). 'HTML/Admin/Posts/Requests.php'; ?>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<a href="/admin/posts/new">
    <div class="button-infos margin">Ajouter un nouvel article</div>
</a>

<div class="box-mine">
    <?php require_once Systeme::root(1). 'HTML/Admin/Posts/Owned.php'; ?>
</div>

<?php $contentRight = ob_get_clean(); ?>