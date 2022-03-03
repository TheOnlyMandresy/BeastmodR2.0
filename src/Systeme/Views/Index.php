<?php
define('TEMPLATE', 'One');
define('PAGE', 'index');
?>

<?php ob_start(); ?>

<div class="box-posts">
    <div class="posts">
    <?php foreach($posts as $post): ?>
        <a href="<?= $post->link; ?>" class="hover">
            <div class="post" style="background-image: url(<?= $post->background; ?>);">
                <p class="title"><?= $post->title; ?></p>
                <p class="tease"><?= $post->teaser; ?></p>
            </div>
        </a>
    <?php endforeach; ?>
    </div>
    
    <div class="buttons-container">
        <a href="/posts" class="button-base">plus</a>
    </div>
</div>

<div class="divided-2-forced">
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