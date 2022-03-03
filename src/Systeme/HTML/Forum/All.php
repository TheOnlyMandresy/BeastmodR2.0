<?php foreach ($all as $data): ?>

<div class="box-topic">
    <p class="texts">
        <span class="title"><?= $data->title; ?></span>
        <span class="author"><?= $data->username; ?> - <?= $data->since; ?></span>
    </p>

    <div class="buttons-container">
        <a href="/forum/<?= $data->id; ?>" class="button-infos">Voir</a>
    </div>
</div>

<?php endforeach; ?>