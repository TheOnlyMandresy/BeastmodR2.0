<?php
define('TEMPLATE', 'Two');
define('PAGE', 'posts-read');
?>


<?php ob_start(); ?>

<div class="infos <?= $boxInfos; ?>">
    <?php require_once Systeme::root(1). 'HTML/Posts/Infos.php'; ?>
</div>

<div class="box-content">
    <div class="content"><?= $post->content; ?></div>
</div>

<div class="see">
    <h2>Voir aussi...</h2>

    <?php require_once Systeme::root(1). 'HTML/Posts/See.php'; ?>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="comments">
    <?php require_once Systeme::root(1). 'HTML/Posts/Comments.php'; ?>
</div>

<?php $contentRight = ob_get_clean(); ?>