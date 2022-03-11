<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-posts-new');

use Systeme\HTML\Form;

$form = new form();
?>
<?php ob_start(); ?>

<?php if (!isset($edit)): ?>
<h1><?= $h1; ?></h1>

<div class="box-new">
    <form method="POST" action="/admin/posts/new/create" enctype="multipart/form-data">
    <?= $form->input(['type' => 'text', 'name' => 'title', 'ph' => 'Titre']); ?>
        <?= $form->input(['type' => 'text', 'name' => 'teaser', 'ph' => 'Teaser']); ?>
        <?= $form->input(['name' => 'image',
            'type' => 'file',
            'accept' => 'image/*',
            'ph' => 'Image de présentation'
        ]); ?>
        <?= $form->select(['name' => 'idSection'], $opt, ['Catégorie de l\'article']); ?>
        <?= $form->textarea(['name' => 'content', 'class' => 'sceditor', 'ph' => 'Contenu de l\'article'], true); ?>
        
        <div class="buttons">
            <button class="button-success">Créer</button>
            <button class="button-warning" formaction="/admin/posts/new/save">Sauvegarder</button>
        </div>
    </form>
</div>

<?php else: ?>
<h1><?= $h1; ?></h1>

<div class="box-new">
    <form method="POST" action="/admin/posts/e/<?= $post->id; ?>/save" enctype="multipart/form-data">
        <?= $form->input(['type' => 'text', 'name' => 'title', 'ph' => 'Titre', 'value' => $post->title]); ?>
        <?= $form->input(['type' => 'text', 'name' => 'teaser', 'ph' => 'Teaser', 'value' => $post->teaser]); ?>
        <?= $form->input(['name' => 'image',
            'type' => 'file',
            'accept' => 'image/*',
            'ph' => 'Image de présentation (Ne pas toucher si vous ne voulez pas la changée)',
            'required' => false
        ]); ?>
        <?= $form->select(['name' => 'idSection', 'selected' => $post->idSection], $opt, ['Catégorie de l\'article']); ?>
        <?= $form->textarea(['name' => 'content', 'class' => 'sceditor', 'ph' => 'Contenu de l\'article', 'value' => $post->content], true); ?>
        <div class="buttons">
            <button class="button-success">Sauvegarder</button>
        <?php if ($post->state == 0): ?>
            <button class="button-warning" formaction="/admin/posts/e/<?= $post->id; ?>/send">Envoyer</button>
        <?php endif; ?>
        </div>
    </form>
</div>
<?php endif; ?>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<?php require_once Systeme::root(1). 'HTML/Admin/Posts/Requests.php'; ?>

<?php $contentRight = ob_get_clean(); ?>