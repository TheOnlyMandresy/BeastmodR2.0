<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-games-new');

use Systeme\HTML\Form;

$form = new form();
?>

<?php ob_start(); ?>
<?php if (!isset($edit)): ?>

<h1><?= $h1; ?></h1>

<div class="box box-new">
    <form method="POST" action="/admin/games/new/create">
        <?= $form->input(['type' => 'text', 'name' => 'name', 'ph' => 'Nom du jeu']); ?>
        <?= $form->input(['type' => 'text', 'name' => 'url', 'ph' => 'Lien du jeu']); ?>
        <?= $form->input(['type' => 'text', 'name' => 'idUser', 'ph' => 'Pseudo de l\'auteur du jeu']); ?>
        <?= $form->input(['type' => 'text', 'name' => 'image', 'ph' => 'Image du jeu']); ?>
        <?= $form->textarea(['name' => 'description', 'ph' => 'Description (facultatif)', 'required' => false], true); ?>
          
        <div class="buttons">
            <button class="button-success">Ajouter</button>
        </div>
    </form>
</div>
<?php else: ?>

<h1><?= $h1; ?></h1>

<div class="box box-edit">
    <form method="POST" action="/admin/games/e/<?= $game->id; ?>/edit">
        <?= $form->input(['type' => 'text', 'name' => 'name', 'ph' => 'Nom du jeu', 'value' => $game->name]); ?>
        <?= $form->input(['type' => 'text', 'name' => 'url', 'ph' => 'Lien du jeu', 'value' => $game->url]); ?>
        <?= $form->input(['type' => 'text', 'name' => 'idUser', 'ph' => 'Pseudo de l\'auteur du jeu', 'value' => $game->username]); ?>
        <?= $form->input(['type' => 'text', 'name' => 'image', 'ph' => 'Image du jeu', 'value' => $game->image]); ?>
        <?= $form->textarea(['name' => 'description', 'ph' => 'Description (facultatif)', 'required' => false, 'value' => $game->description], true); ?>
          
        <div class="buttons">
            <button class="button-success">Modifier</button>
        </div>
    </form>
</div>
<?php endif; ?>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<h2>RIGHT</h2>

<?php $contentRight = ob_get_clean(); ?>