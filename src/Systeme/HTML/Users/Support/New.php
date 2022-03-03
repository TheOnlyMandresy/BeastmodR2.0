<h2>Nouvelle demande</h2>

<form method="POST">
    <?= $form->input(['name' => 'title',
        'type' => 'text',
        'ph' => 'Titre de la demande'
    ]); ?>
    <?= $form->textarea(['name' => 'message',
        'ph' => 'Message'
    ], true); ?>

    <?= $form->input(['name' => 'new',
        'type' => 'submit',
        'value' => 'Enoyer',
        'button' => 'success'
    ]); ?>
</form>