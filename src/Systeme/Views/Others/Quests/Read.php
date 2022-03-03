<?php
define('TEMPLATE', 'Two');
define('PAGE', 'others-quests');

use Systeme\HTML\Form;
$form = new Form();
?>


<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<?php if (isset($ids) && in_array($data->id, $ids)): ?>
<form method="POST">
    <?= $form->input(['name' => 'code',
            'ph' => 'Vous avez un code ?',
            'type' => 'text'
        ], false);
    ?>
</form>
<?php endif; ?>

<div class="box-content">
    <div class="content"><?= $data->content; ?></div>
</div>

<div class="box-reward">
    <h2>Récompense</h2>
    <div class="content"><?= $data->reward; ?></div>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<?php if (isset($ids) && in_array($data->id, $ids)): ?>

<div class="box-steps">
    <?php require_once Systeme::root(1). 'HTML/Quests/Steps.php'; ?>
</div>

<?php elseif ($isLogged && ($end >= time())): ?>
    <a class="button-success" href="/quests/<?= $data->id; ?>/accept">Accepter Quête</a>
<?php else: ?>
    <a class="button-success active">Accepter Quête</a>
<?php endif; ?>

<?php $contentRight = ob_get_clean(); ?>