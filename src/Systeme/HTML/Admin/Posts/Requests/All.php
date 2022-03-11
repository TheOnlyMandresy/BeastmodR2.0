<?php
use Systeme\HTML\Form;

$form = new form();
?>

<?php foreach ($all as $data): ?>
<div class="box-request margin">
    <h2>Requête: <?= $data->id; ?></h2>

    <form method="POST">
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
            
            <?= $form->button(['name' => 'posts-req-edit',
                'btn' => 'warning',
                'text' => 'Modifier'
            ], '/admin/posts/requests/e/' .$data->id. '/edit'); ?>

            <?= $form->button(['name' => 'posts-req-del',
                'btn' => 'danger',
                'text' => 'Supprimer'
            ], '/admin/posts/requests/e/' .$data->id. '/delete'); ?>
        </div>
    </form>
</div>
<?php endforeach; ?>