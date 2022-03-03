<?php foreach ($all as $data): ?>
    <?php if ($data->section !== 'events'): ?>

    <div class="box-post">

        <div class="infos">
            <p class="title"><?= $data->title; ?></p>
            <p class="teaser"><?= $data->teaser; ?></p>
        </div>

        <div class="buttons-container">
            <a href="<?= $data->link; ?>" class="button-base">Lire</a>
        </div>

        <div class="img" style="background-image: url(<?= $data->background; ?>);"></div>
        
    </div>

    <?php endif; ?>
<?php endforeach; ?>