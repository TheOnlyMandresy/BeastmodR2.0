<?php if (isset($requests)): ?>
<div class="box-requests">
    <h2>Requêtes des hauts gradés</h2>

    <div class="requests">

    <?php foreach ($requests as $data): ?>
    <p class="request">
        <span class="content"><?= $data->content; ?></span>

        <?php if ($data->title != null): ?>
        <span class="title">Titre de l'article: <?= $data->title; ?></span>
        <?php endif; ?>
        
        <span class="author">- <?= $data->username; ?></span>
    </p>
    <?php endforeach; ?>

    </div>
</div>
<?php endif; ?>