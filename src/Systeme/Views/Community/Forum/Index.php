<?php
define('TEMPLATE', 'Two');
define('PAGE', 'community-forum-index');
?>


<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="topics">
    <?php require_once Systeme::root(1). 'HTML/Forum/All.php'; ?>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<?php if ($isLogged): ?>
<a href="/forum/new/<?= (isset($section))? $section->id : null; ?>">
    <div class="button-infos">Ouvrir un topic</div>
</a>
<?php endif;?>

<h2>Catégories</h2>
<div class="categories">
    <?php require_once Systeme::root(1). 'HTML/Forum/Categories.php'; ?>
</div>

<?php if ($isLogged) { require_once Systeme::root(1). 'HTML/Forum/Owned.php'; } ?>

<?php $contentRight = ob_get_clean(); ?>