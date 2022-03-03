<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-tickets-read');

use Systeme\HTML\Form;

$form = new form();
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box box-ticket">
    <div class="chat">
        <p class="message principal">
            <span class="username"><?= $ticket->username; ?> :</span>
            <?= $ticket->message; ?>
            <span class="date"><?= $ticket->createAt; ?></span>
        </p>

        <?php foreach ($chat as $message): ?>
            <?php $isUser = ($ticket->idUser === $message->idUser)? 'user' : null; ?>
        <p class="message <?= $isUser; ?>">
            <span class="username"><?= $message->username; ?> :</span>
            <?= $message->message; ?>
            <span class="date"><?= $message->createAt; ?></span>
        </p>
        <?php endforeach; ?>
    </div>

    <form method="POST">
        <?= $form->textarea(['name' => 'message', 'ph' => 'Message'], true); ?>
          
        <div class="buttons">
            <?= $form->input(['name' => 'answer',
                'type' => 'submit',
                'value' => 'Répondre',
                'button' => 'success'
            ], false); ?>
            <?= $form->input(['name' => 'close',
                'type' => 'submit',
                'value' => 'Répondre et fermer',
                'button' => 'warning'
            ], false); ?>
        </div>
    </form>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box">
    <h2>Message principal</h2>
    <p>
        <?= $ticket->message; ?>
    </p>
</div>

<?php $contentRight = ob_get_clean(); ?>