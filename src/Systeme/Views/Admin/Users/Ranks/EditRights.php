<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-ranks-rights-edit');

use Systeme\HTML\Form;

$form = new form();
?>


<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box-edit">
    <form method="POST" action="/admin/ranks/rights/e/<?= $right->id; ?>/edit">
        <?= $form->input(['name' => 'name',
            'type' => 'text',
            'ph' => 'Nom du droit',
            'value' => $right->name
            ]); ?>
        <?= $form->textarea(['name' => 'description',
            'ph' => 'Description (facultatif)',
            'required' => false,
            'value' => $right->description
            ], true); ?>
        <?= $form->input(['name' => 'category',
            'type' => 'text',
            'ph' => 'Category (facultatif)',
            'required' => false,
            'value' => $right->category
            ]); ?>
        
        
        <div class="buttons">
            <button class="button-success">Modifier</button>
        </div>
    </form>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<h2>RIGHT</h2>

<?php $contentRight = ob_get_clean(); ?>