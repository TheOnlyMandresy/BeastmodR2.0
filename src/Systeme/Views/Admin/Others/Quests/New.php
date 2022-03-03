<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-quests-new');

use Systeme\HTML\Form;

$form = new form();
?>


<?php ob_start(); ?>
<h1><?= $h1; ?></h1>

<div class="box box-new">
    <form method="POST" action="/admin/quests/new/create" enctype="multipart/form-data">
        <?= $form->input(['name' => 'name',
            'type' => 'text',
            'ph' => 'Nom de la quête'
        ]); ?>
        <?= $form->input(['name' => 'image',
            'type' => 'file',
            'accept' => 'image/*',
            'ph' => 'Image de présentation'
        ]); ?>
        <?= $form->textarea(['name' => 'content',
            'ph' => 'Histoire'
        ], true); ?>
        <?= $form->textarea(['name' => 'reward',
            'ph' => 'Récompense'
        ], true); ?>
        <?= $form->input(['name' => 'startAt',
            'type' => 'datetime-local',
            'ph' => 'Début de la quête'
        ]); ?>
        <?= $form->input(['name' => 'endAt',
            'type' => 'datetime-local',
            'ph' => 'Fin de la quête'
        ]); ?>
        
        <div class="buttons">
            <button class="button-success">Ajouter</button>
        </div>
    </form>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<h2>RIGHT</h2>

<?php $contentRight = ob_get_clean(); ?>