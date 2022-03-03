<?php
use Systeme\HTML\Form;

$form = new form();
?>

<div class="box-new edit">
<form method="POST" enctype="multipart/form-data">

    <?= $form->input(['name' => 'title',
        'type' => 'text',
        'ph' => 'Titre',
        'value' => $data->title
    ]); ?>
    <?= $form->input(['name' => 'image',
        'type' => 'file',
        'accept' => 'image/*',
        'ph' => 'Image de présentation (Ne pas toucher si vous ne voulez pas la changée)',
        'required' => false
    ]); ?>
    <?= $form->textarea(['name' => 'content',
        'ph' => 'Contenu du topic',
        'value' => $data->content
    ], true); ?>
    <?= $form->select(['name' => 'idSection',
        'selected' => $data->idSection
    ], $opt, ['Catégorie du topic']); ?>
    
    <div class="buttons">
        <?= $form->button(['name' => 'form-edit',
            'btn' => 'warning',
            'text' => 'Modifier'
        ]); ?>
    </div>

</form>
</div>