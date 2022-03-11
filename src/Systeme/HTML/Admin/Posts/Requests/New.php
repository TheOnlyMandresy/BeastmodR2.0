<?php
use Systeme\HTML\Form;

$form = new form();
?>

<h2>Nouvelle requête</h2>

<form method="POST">
    <?= $form->textarea(['name' => 'content',
        'ph' => 'Message'
    ], true); ?>

    <?= $form->input(['name' => 'title',
        'ph' => 'Idée de titre de l\'article (facultatif)',
        'type' => 'text',
        'required' => false
    ]); ?>

    <div class="buttons">
        <?= $form->button(['name' => 'posts-req-new',
            'btn' => 'success',
            'text' => 'Ajouter une demande'
        ]); ?>
    </div>
</form>