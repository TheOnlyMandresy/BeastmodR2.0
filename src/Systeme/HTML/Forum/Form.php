<div class="box-new <?= (isset($edit))? 'edit' : null; ?>">
<form method="POST" enctype="multipart/form-data">
    <?php if (!isset($edit)): ?>

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
            <button class="button-success">Créer</button>
        </div>

    <?php else: ?>

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
            <button class="button-warning">Modifier</button>
        </div>

    <?php endif; ?>
</form>