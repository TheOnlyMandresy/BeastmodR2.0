<?php
define('TEMPLATE', 'One');
define('PAGE', 'index');
?>

<?php ob_start(); ?>

<?php require_once Systeme::root(1). 'HTML/Index/SlideShow.php'; ?>

<div class="divided-2">
    <div class="left">
        <h2><?= $eventsTitle; ?></h2>

        <div class="events">
            <?php require_once Systeme::root(1). 'HTML/Index/Events.php'; ?>
        </div>
    </div>

    <div class="right">
        <h2>Les quêtes</h2>

        <div class="quests">
            <?php require_once Systeme::root(1). 'HTML/Index/Quests.php'; ?>
        </div>
    </div>
</div>

<?php $contentOne = ob_get_clean(); ?>