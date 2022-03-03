<h2>Recherche</h2>

<form method="POST">
    <?php $value = (!empty($_POST))? Systeme::security(['text'=> $_POST['username']], 'post') : null; ?>
    <?= $form->input(['name' => 'username',
        'type' => 'text',
        'ph' => 'Pseudo du joueur recherché',
        'value' => $value
    ], false); ?>
</form>