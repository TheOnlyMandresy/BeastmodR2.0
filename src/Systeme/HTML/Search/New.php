<h2>Ils sont nouveaux sur <?= Systeme::getSystemInfos('website'); ?></h2>

<?php foreach ($datas as $data): ?>
    <div class="user">

        <p><?= $data->username; ?></p>
        <img src="<?= $data->look; ?>" />
        <p>Dernière connexion: <?= $data->last; ?></p>
        <a href="<?= $data->link; ?>" class="button-base">Profil</a>
        
    </div>
<?php endforeach; ?>