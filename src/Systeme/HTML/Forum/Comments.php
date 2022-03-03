<?php
use Systeme\HTML\Forum\Dependencies\Comments;
use Systeme\HTML\Form;

if (isset($data->id)) { $id = $data->id; }
if ($isLogged) { $form = new Form(); }
?>

<h2>Réponses (<?= $comments; ?>)</h2>

<?php $commentsLoad = new Comments($id, $pagination); ?>

<?php if ($isLogged): ?>
<div class="box-send">
    <?= $commentsLoad->pagination(); ?>
    
    <?php if ($isLogged): ?>
    <div class="send">
        <form method="POST">
            <div class="form">
                <?= $form->textarea(['name' => 'message',
                    'ph' => 'Quelque chose à dire ?'
                ]); ?>
                
                <div class="buttons">
                    <?= $form->button(['name' => 'forum-comment',
                        'btn' => 'success',
                        'text' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8l4 4-4 4M8 12h7"/></svg>'
                    ], false); ?>
                </div>
            </div>

            <?= $form->input(['name' => 'answerTo',
                'type' => 'hidden',
                'value' => 0
            ], false); ?>
        </form>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>