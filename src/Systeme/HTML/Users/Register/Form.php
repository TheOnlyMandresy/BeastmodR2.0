<form method="POST">
<?php if (empty($_POST)): ?>

    <?= $form->input(['name' => 'username',
        'type' => 'text',
        'ph' => 'Identifiant'
    ], false); ?>

    <?= $form->input(['name' => 'email',
        'type' => 'email',
        'ph' => 'Address email'
    ], false); ?>

    <?= $form->input(['name' => 'password',
        'type' => 'password',
        'ph' => 'Mot de passe'
    ], false); ?>

    <?= $form->input(['name' => 'checkPass',
        'type' => 'password',
        'ph' => 'Mot de passe (Vérification)'
    ], false); ?>

    <?= $form->radio('gender', 0, 'Homme', true); ?>
    <?= $form->radio('gender', 1, 'Femme'); ?>
    
<?php else: ?>

    <?= $form->input(['name' => 'username',
        'type' => 'text',
        'ph' => 'Identifiant',
        'value' => $_POST['username']
    ], false); ?>

    <?= $form->input(['name' => 'email',
        'type' => 'email',
        'ph' => 'Address email',
        'value' => (isset($_POST['email'])) ? $_POST['email'] : null
    ], false); ?>

    <?= $form->input(['name' => 'password',
        'type' => 'password',
        'ph' => 'Mot de passe'
    ], false); ?>

    <?= $form->input(['name' => 'checkPass',
        'type' => 'password',
        'ph' => 'Mot de passe (Vérification)'
    ], false); ?>

    <?php
        if (isset($_POST['gender']) && $_POST['gender'] == 1) {
            $male = false;
            $female = true;
        } else {
            $male = true;
            $female = false;
        }
    ?>

    <?= $form->radio('gender', 0, 'Homme', $male); ?>
    <?= $form->radio('gender', 1, 'Femme', $female); ?>

<?php endif; ?>

    <div class="buttons-container">
        <?= $form->button(['name' => 'register',
            'btn' => 'success',
            'text' => 'C\'est parti!'
        ], false); ?>
    </div>
    
</form>