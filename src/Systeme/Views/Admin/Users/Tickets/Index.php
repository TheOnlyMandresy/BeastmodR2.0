<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-tickets-index');
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box">
    <h2>Sans réponse</h2>
    <table>
        <tbody>
        <?php foreach ($all as $data): ?>  
            <?php if ($data->state == 1): ?>   
            <tr>
                <td><?= $data->id; ?></td>
                <td><?= $data->title; ?></td>
                <td><?= $data->username; ?></td>
                <td><?= $data->createAt; ?></td>
                <td><a class="button-success" href="/admin/tickets/<?= $data->id; ?>">Répondre</a></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="box">
    <h2>En attente de réponse</h2>
    <table>
        <tbody>
        <?php foreach ($all as $data): ?>  
            <?php if ($data->state == 2): ?>   
            <tr>
                <td><?= $data->id; ?></td>
                <td><?= $data->title; ?></td>
                <td><?= $data->username; ?></td>
                <td><?= $data->createAt; ?></td>
                <td><a class="button-success" href="/admin/tickets/<?= $data->id; ?>">Répondre</a></td>
                <td><a class="button-danger" href="/admin/tickets/<?= $data->id; ?>/close">Fermer</a></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box">
    <h2>Fermés</h2>
    <table>
        <tbody>
        <?php foreach ($all as $data): ?>  
            <?php if ($data->state == 0): ?>   
            <tr>
                <td><?= $data->id; ?></td>
                <td><?= $data->title; ?></td>
                <td><?= $data->username; ?></td>
                <td><?= $data->createAt; ?></td>
                <td><a class="button-warning" href="/admin/tickets/<?= $data->id; ?>/open">Rouvrir</a></td>
                <td><a class="button-danger" href="/admin/tickets/<?= $data->id; ?>/delete">Supprimer</a></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $contentRight = ob_get_clean(); ?>