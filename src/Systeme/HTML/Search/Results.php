<h2>Résultats</h2>

<?php foreach ($result as $data): ?>
<div class="user">
    <img src="<?= $data->look; ?>" />
    <div class="infos">
        <p><?= $data->username; ?></p>
        <p>Dernière connexion: <?= $data->last; ?></p>
    </div>
    <a href="<?= $data->link; ?>" class="button-base">Profil</a>
</div>
<?php endforeach; ?>