<?php foreach ($all as $data): ?>

    <div class="box-event">

        <div class="infos">
            <p class="title"><?= $data->title; ?></p>
            <p class="date">Débute le <?= $data->startAt; ?></p>
        </div>

        <div class="buttons-container">
            <a href="/events/<?= $data->id; ?>" class="button-base">Lire</a>
        </div>

        <div class="img" style="background-image: url(<?= $data->background; ?>);"></div>
        
    </div>

<?php endforeach; ?>