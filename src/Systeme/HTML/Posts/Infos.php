<div class="box-infos" style="background-image: url(<?= $post->background; ?>);">
    <div class="box-img" style="background-image: url(<?= $post->authorLook; ?>);"></div>
    
    <div class="infos">
        <h1 class="title"><?= $h1; ?></h1>
        <p class="author">
            <span class="text">Écrit par </span>
            <span class="username">
                <a href="/users/profil/<?= $post->authorUsername; ?>"><?= $post->authorUsername; ?></a>
            </span>
        </p>
        <?php if ($post->idCorrectorUser > 0): ?>
        <p class="corrector">
            <img src="<?= $post->correctorLook; ?>" />
            <span class="text">Édit de </span>
            <span class="username">
                <a href="/users/profil/<?= $post->correctorUsername; ?>"><?= $post->correctorUsername; ?></a>
            </span>
        </p>
        <?php endif; ?>
    </div>
</div>

<div class="box-create">
    <p>Créer le:</p>
    <p><?= $post->createAt; ?></p>
</div>

<?php if ($post->idCorrectorUser > 0): ?>
<div class="box-edit">
    <p>Modifier le:</p>
    <p><?= $post->editAt; ?></p>
</div>
<?php endif; ?>