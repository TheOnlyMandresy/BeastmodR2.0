<div class="slideshow margin">
    <div class="inMovement" style="right: 0px;">
        <?php foreach($posts as $key => $post): ?>
            <a href="<?= $post->link; ?>" class="hover">
                <div class="post <?php if ($key == 0) echo 'show'; ?>" style="background-image: url(<?= $post->background; ?>);">
                    <div class="texts">
                        <p class="title"><?= $post->title; ?></p>
                        <p class="tease"><?= $post->teaser; ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>