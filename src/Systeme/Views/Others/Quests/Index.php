<?php
define('TEMPLATE', 'Two');
define('PAGE', 'others-quests');
?>


<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box-quests">
    <?php require_once Systeme::root(1). 'HTML/Quests/All.php'; ?>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<?php if (isset($ids)): ?>
<div class="box-quests">
    <?php require_once Systeme::root(1). 'HTML/Quests/Owned.php'; ?>
</div>
<?php endif; ?>

<!-- 
    +5 par quêtes acceptées
    +1 par indices
    +10 par quêtes terminéés

    Top 3
 -->

<?php $contentRight = ob_get_clean(); ?>