<?php
define('TEMPLATE', 'Two');
define('PAGE', 'posts-index');
?>


<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="all">
    <?php require_once Systeme::root(1). 'HTML/Posts/All.php'; ?>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box-categories margin">
    <h2>Catégories</h2>

    <div class="categories">
        <?php require_once Systeme::root(1). 'HTML/Posts/Categories.php'; ?>
    </div>
</div>

<div class="box-flux">
        <?php require_once Systeme::root(1). 'HTML/Posts/Flux.php'; ?>
</div>

<?php $contentRight = ob_get_clean(); ?>