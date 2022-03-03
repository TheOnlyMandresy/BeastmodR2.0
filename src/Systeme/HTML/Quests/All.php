<?php foreach ($all as $data):
    $end = Systeme::dateFormat('timestamp', $data->endAt);
?>
    <div class="quest">
        <h2>
            <a href="/quests/<?= $data->id; ?>"><?= $data->name; ?></a>
        </h2>

        <p>
            <span class="content"><?= $data->content; ?></span>
            <span class="title">Récompense</span>
            <span class="reward"><?= $data->reward; ?></span>
        </p>
        
        <div class="buttons">

            <a class="button-infos" href="/quests/<?= $data->id; ?>">Lire quête</a>

        <?php if ($end <= time()): ?>

            <a class="button-success active">Accepter Quête</a>

        <?php else: ?>

            <?php if ((isset($ids) && !in_array($data->id, $ids)) || !isset($ids) && $isLogged): ?>
                <a class="button-success" href="/quests/<?= $data->id; ?>/accept">Accepter Quête</a>
            <?php else: ?>
                <a class="button-success active">Accepter Quête</a>
            <?php endif; ?>

        <?php endif; ?>

        </div>
    </div>
<?php endforeach; ?>