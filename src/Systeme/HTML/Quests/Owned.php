<h2>Vos quêtes acceptées</h2>

<div class="quests">
<?php for ($i = 0; $i < count($owned); $i++): ?>

    <div class="quest">
        <p class="title"><?= $owned[$i]->name; ?></p>
        
        <div class="buttons">
            <a href="/quests/<?= $owned[$i]->id; ?>" class="button-infos">Voir la quête</a>
        </div>
    </div>

<?php endfor; ?>
</div>