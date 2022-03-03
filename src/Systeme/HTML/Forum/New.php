<?php
use Systeme\HTML\Form;

$form = new form();
?>

<div class="box-new">
<form method="POST" enctype="multipart/form-data">

    <?= $form->input(['name' => 'title',
        'type' => 'text',
        'ph' => 'Titre'
    ]); ?>
    <?= $form->input(['name' => 'image',
        'type' => 'file',
        'accept' => 'image/*',
        'ph' => 'Image de présentation'
    ]); ?>
    <?= $form->textarea(['name' => 'content',
        'ph' => 'Contenu du topic'
    ], true); ?>
    <?= $form->select(['name' => 'idSection',
        'selected' => $id
    ], $opt, ['Catégorie du topic']); ?>
    
    <div class="buttons">
        <?= $form->button(['name' => 'form-new',
            'btn' => 'success',
            'text' => 'Créer'
        ]); ?>
    </div>

</form>
</div>