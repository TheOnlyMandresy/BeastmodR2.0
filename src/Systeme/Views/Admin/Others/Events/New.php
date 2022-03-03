<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-events-new');

use Systeme\HTML\Form;

$form = new form();
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box box-new">
    <form method="POST" enctype="multipart/form-data">
        <?= $form->input(['type' => 'input', 'name' => 'title', 'ph' => 'Titre']); ?>
        <?= $form->input(['type' => 'input', 'name' => 'appartUrl', 'ph' => 'Lieu de l\'événement']); ?>
        <?= $form->input(['name' => 'image',
            'type' => 'file',
            'accept' => 'image/*',
            'ph' => 'Image de présentation'
        ]); ?>
        <?= $form->textarea(['name' => 'content', 'ph' => 'Présentation'], true); ?>
        <?= $form->textarea(['name' => 'rewards', 'ph' => 'Récompenses (facultatif)', 'required' => false], true); ?>
        <?= $form->input(['type' => 'input', 'name' => 'rewardFirst', 'ph' => 'Premier prix']); ?>
        <?= $form->input(['type' => 'input', 'name' => 'rewardSecond', 'ph' => 'Deuxième prix']); ?>
        <?= $form->input(['type' => 'input', 'name' => 'rewardThird', 'ph' => 'Troisième prix']); ?>
        <?= $form->input(['type' => 'input', 'name' => 'rewardOthers', 'ph' => 'Participants (falcutatif)', 'required' => false]); ?>
        <?= $form->input(['type' => 'datetime-local', 'name' => 'startAt', 'ph' => 'Début de l\'événement']); ?>
        <?= $form->input(['type' => 'datetime-local', 'name' => 'endAt', 'ph' => 'Fin de l\'événement']); ?>
        
        <div class="buttons">
            <button class="button-success">Ajouter événement</button>
        </div>
    </form>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<h2>RIGHT</h2>

<?php $contentRight = ob_get_clean(); ?>