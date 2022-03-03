<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-partners-index');
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box">
    <table>
        <tbody>
        <?php foreach ($partners as $partner): ?>        
            <tr>
                <td><?= $partner->name; ?> - <?= $partner->author; ?></td>
                <td><a class="button-warning" href="/admin/partners/e/<?= $partner->id; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/partners/e/<?= $partner->id; ?>/delete">Supprimer</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<a href="/admin/partners/new" class="button-infos">Créer un nouveau partenariat</a>

<?php $contentRight = ob_get_clean(); ?>