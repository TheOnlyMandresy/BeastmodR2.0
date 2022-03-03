<?php use Systeme\HTML\Bubble; ?>

<h2>Titre: <?= $ticket->title; ?></h2>

<div class="chat">
    <?= Bubble::load($ticket->idBubble, [
            'message' => $ticket->message,
            'type' => 'comment',
            'me' => true,
            'src' => $ticket->look
        ]);
    ?>

    <div class="answers">
    <?php foreach ($chat as $data) {
        $mine = ($data->idUser == $me)? true : false;

        echo Bubble::load($data->idBubble, [
            'message' => $data->message,
            'type' => 'comment',
            'me' => $mine,
            'src' => $data->look
        ]);
    } ?>
    </div>
</div>

<?php if ($ticket->state != 0): ?>
<form method="POST">
    <?= $form->textarea(['name' => 'message', 'ph' => 'Répondre'], true); ?>
    <?= $form->input(['name' => 'answer',
        'type' => 'submit',
        'value' => 'Envoyer', 
        'button' => 'success'
    ], false); ?>
</form>
<?php endif; ?>