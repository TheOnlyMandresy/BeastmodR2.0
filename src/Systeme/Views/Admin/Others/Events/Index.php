<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-others-events');
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box">
    <table>
        <tbody>
        <?php foreach ($events as $event): ?>        
            <tr>
                <td><?= $event->title; ?></td>
                <td><a class="button-warning" href="/admin/events/e/<?= $event->id; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/events/e/<?= $event->id; ?>/delete">Supprimer</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<a class="button-infos" href="/admin/events/new">Ajouter un nouvel événement</a>

<?php $contentRight = ob_get_clean(); ?>