<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-posts-requests');
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="requests">
    <?php require_once Systeme::root(1). 'HTML/Admin/Posts/Requests/All.php'; ?>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box-new-request">
    <?php require_once Systeme::root(1). 'HTML/Admin/Posts/Requests/New.php'; ?>
</div>

<?php $contentRight = ob_get_clean(); ?>