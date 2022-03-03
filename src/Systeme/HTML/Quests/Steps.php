<h2>Vos Trouvailles</h2>

<?php foreach ($steps as $step): ?>

<div class="step">
    <p class="name"><?= $step->name; ?></p>
    <p class="content"><?= $step->content; ?></p>
</div>

<?php endforeach; ?>