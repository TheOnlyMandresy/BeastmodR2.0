<?php
define('TEMPLATE', 'Two');
define('PAGE', 'users-param');

use Systeme\HTML\Form;

$form = new Form();
?>

<?php ob_start(); ?>

<div class="box-preferences margin">
    <?php require_once Systeme::root(1). 'HTML/Users/Parameters/Preferences.php'; ?>
</div>

<div class="box-background margin">
    <?php require_once Systeme::root(1). 'HTML/Users/Parameters/Background.php'; ?>
</div>

<div class="box-bubbles">
    <?php require_once Systeme::root(1). 'HTML/Users/Parameters/Bubbles.php'; ?>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box-infos margin">
    <?php require_once Systeme::root(1). 'HTML/Users/Parameters/Infos.php'; ?>
</div>

<div class="box-look">
    <h2>Éditeur de look</h2>

    <?php require_once Systeme::root(1). 'HTML/Users/Parameters/Avatarimage.php'; ?>
</div>

<?php $contentRight = ob_get_clean(); ?>