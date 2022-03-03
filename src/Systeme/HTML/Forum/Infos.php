<h2>
    <span>Créer le:</span>
    <span><?= $data->createAt; ?></span>
</h2>

<?php if (!is_null($data->editAt)): ?>

<h2>
    <span>Modifier le:</span>
    <span><?= $data->editAt; ?></span>
</h2>

<?php endif; ?>