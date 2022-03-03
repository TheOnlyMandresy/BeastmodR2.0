<?php
define('TEMPLATE', 'Two');
define('PAGE', 'users-register');

$form = new \Systeme\HTML\Form();
?>

<?php ob_start(); ?>

<div class="box-infos">
    <?php require_once Systeme::root(1). 'HTML/Users/Register/Infos.php'; ?>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box-register">
    <?php require_once Systeme::root(1). 'HTML/Users/Register/Form.php'; ?>
</div>

<?php $contentRight = ob_get_clean(); ?>