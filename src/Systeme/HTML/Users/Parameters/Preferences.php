<h2>Préférences du compte</h2>

<form method="POST">
    <?= $form->input(['name' => 'motto',
        'type' => 'text',
        'ph' => 'Quelle est votre devise ?',
        'value' => $all->motto,
        'max' => 40
    ]); ?>
    
    <?= $form->input(['name' => 'radio',
        'type' => 'checkbox',
        'ph' => 'État de la radio à la connexion ' .$radio,
        'value' => 1,
        'required' => false,
        'checked' => $radioState
    ]); ?>

    <div class="buttons-container">
        <?= $form->button(['name' => 'param-pref',
            'btn' => 'success', 
            'text' => 'Sauvegarder'
        ]); ?>
    </div>
</form>