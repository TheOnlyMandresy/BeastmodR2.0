<?php
define('TEMPLATE', 'Three');
define('PAGE', 'admin-index');
?>
<?php ob_start(); ?>

<div class="box">
<h1><?= $h1; ?></h1>
<p><?= $p; ?></p>
</div>

<?php $contentTop = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box">
    <h2>Les topics</h2>
    <table>
        <thead>
            <th>ID</th>
            <th>Titre</th>
            <th>Pseudo</th>
        </thead>
        <tbody>
        <?php foreach ($datas as $data): ?> 
            <tr>
                <td><?= $data->id; ?></td>
                <td><?= $data->title; ?></td>
                <td><?= $data->username; ?></td>
                <td><a class="button-warning" href="/admin/forum/e/<?= $data->id; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/forum/e/<?= $data->id; ?>/delete">Supprimer</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box">
    <h2>Signalés</h2>
    
</div>

<?php $contentRight = ob_get_clean(); ?>