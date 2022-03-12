<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-others-events-edit');

use Systeme\HTML\Form;

$form = new form();
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box box-new">
    <h2>Événément</h2>
    <form method="POST" action="/admin/events/e/<?= $id; ?>/event" enctype="multipart/form-data">
        <?= $form->input(['type' => 'input', 'name' => 'title', 'ph' => 'Titre', 'value' => $event->title]); ?>
        <?= $form->input(['type' => 'input', 'name' => 'appartUrl', 'ph' => 'Lieu de l\'événement', 'value' => $event->appartUrl]); ?>
        <?= $form->input(['name' => 'image',
            'type' => 'file',
            'accept' => 'image/*',
            'ph' => 'Image de présentation (Ne pas toucher si vous ne voulez pas la changée)',
            'required' => false
        ]); ?>
        <?= $form->textarea(['name' => 'content', 'ph' => 'Présentation', 'value' => $event->content], true); ?>
        <?= $form->textarea(['name' => 'rewards', 'ph' => 'Récompenses (texte facultatif)', 'required' => false, 'value' => $event->rewards], true); ?>
        <?= $form->input(['type' => 'input', 'name' => 'rewardFirst', 'ph' => 'Premier prix', 'value' => $event->first]); ?>
        <?= $form->input(['type' => 'input', 'name' => 'rewardSecond', 'ph' => 'Deuxième prix', 'value' => $event->second]); ?>
        <?= $form->input(['type' => 'input', 'name' => 'rewardThird', 'ph' => 'Troisième prix', 'value' => $event->third]); ?>
        <?= $form->input(['type' => 'input', 'name' => 'rewardOthers', 'ph' => 'Participants (falcutatif)', 'required' => false, 'value' => $event->others]); ?>
        <?= $form->input(['type' => 'datetime-local', 'name' => 'startAt', 'ph' => 'Début de l\'événement', 'value' => $event->startAt]); ?>
        <?= $form->input(['type' => 'datetime-local', 'name' => 'endAt', 'ph' => 'Fin de l\'événement', 'value' => $event->endAt]); ?>
        
        <div class="buttons">
            <button class="button-success">Sauvegarder</button>
        </div>
    </form>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box box-new">
    <h2 class="title">Les gagnants ?</h2>
    <form method="POST" action="/admin/events/e/<?= $id; ?>/winners">
        <?= $form->input(['type' => 'text', 'name' => 'idFirstUser', 'ph' => 'Vainqueur du premier prix', 'value' => $firstPlace]); ?>
        <?= $form->input(['type' => 'text', 'name' => 'idSecondUser', 'ph' => 'Vainqueur du second prix', 'value' => $secondPlace]); ?>
        <?= $form->input(['type' => 'text', 'name' => 'idThirdUser', 'ph' => 'Vainqueur du troisième prix', 'value' => $thirdPlace]); ?>
        <div class="buttons">
            <button class="button-success">Sauvegarder</button>
        </div>
    </form>
</div>

<?php $contentRight = ob_get_clean(); ?>