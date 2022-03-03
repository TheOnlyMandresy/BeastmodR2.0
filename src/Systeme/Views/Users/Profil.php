<?php
define('TEMPLATE', 'Two');
define('PAGE', 'users-profil');

use Systeme\HTML\Users\Look;
?>
<?php ob_start(); ?>

<div class="profil">
        <h1><span>Profil de </span> <?= $user->username; ?></h1>
        <p class="motto">“<?= $user->motto; ?>”</p>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="avatar">
    <div class="box background" style="background-image: url('<?= $user->background; ?>');"></div>
    <div class="star"></div>
    <img src="<?= Look::load($user->look, ['bodydirection' => 'SW', 'headdirection' => 'S', 'action' => 'wave', 'face' => 'smile', 'size' => 'XL']); ?>" />
</div>

<?php $contentRight = ob_get_clean(); ?>