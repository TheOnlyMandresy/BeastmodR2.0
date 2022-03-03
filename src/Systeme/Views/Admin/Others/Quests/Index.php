<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-quests-index');
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box">
    <h2>En cours</h2>
    <table>
        <tbody>
        <?php foreach ($all as $data): ?>
            <?php
                $start = Systeme::dateFormat('timestamp', $data->startAt);
                $end = Systeme::dateFormat('timestamp', $data->endAt);
            ?>
            
            <?php if ($start <= time() && $end > time()): ?>
            <tr>
                <td><?= $data->name; ?></td>
                <td>Début: <?= $data->startAt; ?></td>
                <td>Fin: <?= $data->endAt; ?></td>
                <td><a class="button-warning" href="/admin/quests/e/<?= $data->id; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/quests/e/<?= $data->id; ?>/delete">Supprimer</a></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Bientôt</h2>
    <table>
        <tbody>
        <?php foreach ($all as $data): ?>
            <?php
                $start = Systeme::dateFormat('timestamp', $data->startAt);
                $end = Systeme::dateFormat('timestamp', $data->endAt);
            ?>
            
            <?php if ($start > time()): ?>
            <tr>
                <td><?= $data->name; ?></td>
                <td>Début: <?= $data->startAt; ?></td>
                <td>Fin: <?= $data->endAt; ?></td>
                <td><a class="button-warning" href="/admin/quests/e/<?= $data->id; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/quests/e/<?= $data->id; ?>/delete">Supprimer</a></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="box">
    <h2>Terminé</h2>
    <table>
        <tbody>
        <?php foreach ($all as $data): ?>
            <?php
                $start = Systeme::dateFormat('timestamp', $data->startAt);
                $end = Systeme::dateFormat('timestamp', $data->endAt);
            ?>
            
            <?php if ($end <= time()): ?>
            <tr>
                <td><?= $data->name; ?></td>
                <td>Début: <?= $data->startAt; ?></td>
                <td>Fin: <?= $data->endAt; ?></td>
                <td><a class="button-warning" href="/admin/quests/e/<?= $data->id; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/quests/e/<?= $data->id; ?>/delete">Supprimer</a></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<a href="/admin/quests/new" class="button-infos">Créer une nouvelle quête</a>

<?php $contentRight = ob_get_clean(); ?>