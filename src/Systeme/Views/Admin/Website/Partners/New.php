<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-partners-new');

use Systeme\HTML\Form;

$form = new form();
?>


<?php ob_start(); ?>
<?php if (!isset($edit)): ?>
<h1><?= $h1; ?></h1>

<div class="box box-new">
    <form method="POST" action="/admin/partners/new/create">
        <?= $form->input(['type' => 'text', 'name' => 'name', 'ph' => 'Nom de l\'organisation']); ?>
        <?= $form->input(['type' => 'text', 'name' => 'url', 'ph' => 'Lien du site']); ?>
        <?= $form->input(['type' => 'text', 'name' => 'author', 'ph' => 'Auteur de l\'organisation']); ?>
        <?= $form->input(['type' => 'text', 'name' => 'logo', 'ph' => 'Logo du site']); ?>
        <?= $form->textarea(['name' => 'description', 'ph' => 'Description (facultatif)', 'required' => false], true); ?>
          
        <div class="buttons">
            <button class="button-success">Ajouter</button>
        </div>
    </form>
</div>
<?php else: ?>
<h1><?= $h1; ?></h1>

<div class="box box-edit">
    <form method="POST" action="/admin/partners/e/<?= $partner->id; ?>/edit">
        <?= $form->input(['type' => 'text', 'name' => 'name', 'ph' => 'Nom de l\'organisation', 'value' => $partner->name]); ?>
        <?= $form->input(['type' => 'text', 'name' => 'url', 'ph' => 'Lien du site', 'value' => $partner->url]); ?>
        <?= $form->input(['type' => 'text', 'name' => 'author', 'ph' => 'Auteur de l\'organisation', 'value' => $partner->author]); ?>
        <?= $form->input(['type' => 'text', 'name' => 'logo', 'ph' => 'Logo du site', 'value' => $partner->logo]); ?>
        <?= $form->textarea(['name' => 'description', 'ph' => 'Description (facultatif)', 'required' => false, 'value' => $partner->description], true); ?>
          
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