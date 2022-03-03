<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-ranks-index');
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box-teams">
    <h2>Supérieurs</h2>
    <table>
        <tbody>
        <?php foreach ($all as $data): ?>
            <?php if ($data->idRights === 'all'): ?>  
            <tr>
                <td><?= $data->username; ?></td>
                <td><?= $data->name; ?></td>
                <td><a class="button-warning" href="/admin/ranks/e/<?= $data->idUser; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/ranks/e/<?= $data->id; ?>/delete">Retirer</a></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Reponsables</h2>
    <table>
        <tbody>
        <?php foreach ($all as $data): ?>
            <?php if ($data->responsable && $data->idRights !== 'all'): ?>  
            <tr>
                <td><?= $data->username; ?></td>
                <td><?= $data->name; ?></td>
                <td><a class="button-warning" href="/admin/ranks/e/<?= $data->idUser; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/ranks/e/<?= $data->id; ?>/delete">Retirer</a></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Staffs</h2>
    <table>
        <tbody>
        <?php foreach ($all as $data): ?>
            <?php if ($data->responsable == false && $data->idRights !== 'all'): ?>     
            <tr>
                <td><?= $data->username; ?></td>
                <td><?= $data->name; ?></td>
                <td><a class="button-warning" href="/admin/ranks/e/<?= $data->idUser; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/ranks/e/<?= $data->id; ?>/delete">Retirer</a></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<a href="/admin/ranks/new" class="button-infos">Donner des droits à un nouveau joueur</a>

<?php if ($team): ?>
<div class="box-team">
    <h2>Votre équipe</h2>
    <table>
        <tbody>
        <?php foreach ($team as $data): ?>   
            <tr>
                <td><?= $data->username; ?></td>
                <td><?= $data->name; ?></td>
                <td><a class="button-warning" href="/admin/ranks/e/<?= $data->idUser; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/ranks/e/<?= $data->id; ?>/delete">Retirer</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php $contentRight = ob_get_clean(); ?>