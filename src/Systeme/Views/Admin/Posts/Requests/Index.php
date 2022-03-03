<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-posts-requests');

use Systeme\HTML\Form;

$form = new form();
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<?php foreach ($all as $data): ?>
<div class="box-requests">
    <h2>Requête: <?= $data->title; ?></h2>
    <form method="POST" action="/admin/posts/requests/e/<?= $data->id; ?>/edit">
        <?= $form->textarea([ 'name' => 'content',
            'ph' => 'Message',
            'value' => $data->content
        ], true); ?>
        <?= $form->input(['name' => 'title',
            'ph' => 'Idée de titre de l\'article (facultatif)',
            'type' => 'text',
            'required' => false,
            'value' => $data->title
        ]); ?>

        <div class="buttons">
            <button class="button-warning">Modifier</button>
            <button formaction="/admin/posts/requests/e/<?= $data->id; ?>/delete" class="button-danger">Supprimer</button>
        </div>
    </form>
</div>
<?php endforeach; ?>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box-new-request">
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
            <button class="button-success">Ajouter une demande</button>
        </div>
    </form>
<div>

<?php $contentRight = ob_get_clean(); ?>