<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-games-index');
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box">
    <table>
        <tbody>
        <?php foreach ($games as $game): ?>        
            <tr>
                <td><?= $game->name; ?></td>
                <td><a class="button-warning" href="/admin/games/e/<?= $game->id; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/games/e/<?= $game->id; ?>/delete">Supprimer</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<a href="/admin/games/new" class="button-infos">Ajouter un nouveau jeu</a>

<?php $contentRight = ob_get_clean(); ?>