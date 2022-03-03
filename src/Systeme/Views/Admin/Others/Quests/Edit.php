<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-events-edit');

use Systeme\HTML\Form;

$form = new form();
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box box-new">
    <h2>Quête</h2>
    <form method="POST" action="/admin/quests/e/<?= $data->id; ?>/edit" enctype="multipart/form-data">
        <?= $form->input(['name' => 'name',
            'type' => 'text',
            'ph' => 'Nom de la quête',
            'value' => $data->name
        ]); ?>
        <?= $form->input(['name' => 'image',
            'type' => 'file',
            'accept' => 'image/*',
            'ph' => 'Image de présentation (Ne pas toucher si vous ne voulez pas la changée)',
            'required' => false
        ]); ?>
        <?= $form->textarea(['name' => 'content',
            'ph' => 'Histoire',
            'value' => $data->content
        ], true); ?>
        <?= $form->textarea(['name' => 'reward',
            'ph' => 'Récompense',
            'value' => $data->reward
        ], true); ?>
        <?= $form->input(['name' => 'startAt',
            'type' => 'datetime-local',
            'ph' => 'Début de la quête',
            'value' => $data->startAt
        ]); ?>
        <?= $form->input(['name' => 'endAt',
            'type' => 'datetime-local',
            'ph' => 'Fin de la quête',
            'value' => $data->endAt
        ]); ?>
        <div class="buttons">
            <button class="button-success">Sauvegarder</button>
        </div>
    </form>
</div>

<?php if (isset($winners)): ?>
<div class="box box-winners">
    <h2>Gagnants</h2>
    
    <?php foreach ($winners as $winner): ?>
    <div class="winner">
        <p><?= $winner->username; ?></p>
        <p><?= $winner->createAt; ?></p>
    </div>
    <?php endforeach; ?>

</div>
<?php endif; ?>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box box-step">
    <h2 class="title">Etapes</h2>
    <form method="POST" action="/admin/quests/e/<?= $data->id; ?>/step">
        <?= $form->input(['name' => 'name',
            'type' => 'text',
            'ph' => 'Nom de l\'étape'
        ]); ?>
        <?= $form->textarea(['name' => 'content',
            'ph' => 'Histoire de l\'étape'
        ], true); ?>
        <?= $form->input(['name' => 'code',
            'type' => 'text',
            'ph' => 'Code déclencheur de l\'étape'
        ]); ?>
        <?= $form->input(['name' => 'last',
            'required' => false,
            'type' => 'checkbox',
            'ph' => 'Est-ce la dernière étape ?'
        ]); ?>
        
        <div class="buttons">
            <button class="button-success">Ajouter une étape</button>
        </div>
    </form>
</div>

<?php foreach ($datas as $step): ?>
    <?php $checked = ($step->last)? true : false; ?>
<div class="box box-step">
    <h2 class="title">Etapes: <?= $step->name; ?></h2>
    <form method="POST" action="/admin/quests/e/<?= $data->id; ?>/step/<?= $step->id; ?>">
        <?= $form->input(['name' => 'name',
            'type' => 'text',
            'ph' => 'Nom de l\'étape',
            'value' => $step->name
        ]); ?>
        <?= $form->textarea(['name' => 'content',
            'ph' => 'Histoire de l\'étape',
            'value' => $step->content
        ], true); ?>
        <?= $form->input(['name' => 'code',
            'type' => 'text',
            'ph' => 'Code déclencheur de l\'étape',
            'value' => $step->code
        ]); ?>
        <?= $form->input(['name' => 'last',
            'required' => false,
            'type' => 'checkbox',
            'ph' => 'Est-ce la dernière étape ?',
            'checked' => $checked
        ]); ?>
        
        <div class="buttons">
            <button class="button-infos">Modifier l'étape</button>
        </div>
    </form>
</div>
<?php endforeach; ?>

<?php $contentRight = ob_get_clean(); ?>