<?php use Systeme\HTML\Posts\Dependencies\See; ?>

<div class="box-category">
    <?= See::inCategory($post->id, $post->idSection); ?>
    
    <div class="buttons-container">
        <?= See::buttons($post->id, $post->idSection); ?>
    </div>
</div>

<div class="new"><?= See::inNewest($post->id); ?></div>