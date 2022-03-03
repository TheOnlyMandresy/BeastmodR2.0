<h2>Foundation et gestion du site</h2>

<div class="responsable">
<?php foreach ($all as $data): ?>
    <?php if ($data->idRights === 'all' || $data->responsable > 1): ?>

    <div class="staff">
        <img src="<?= $data->look; ?>" />
        <p class="infos">
            <span class="username">
                <a href="<?= $data->link; ?>"><?= $data->username; ?></a>
            </span>
            <span class="fonction">fonction: <?= $data->name; ?></span>
            <span class="description">rôle: <?= $data->description; ?></span>
        </p>
    </div>

    <?php endif; ?>
<?php endforeach; ?>
</div>