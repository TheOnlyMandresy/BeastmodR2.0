<?php
define('TEMPLATE', 'Two');
define('PAGE', 'users-support');

use Systeme\HTML\Form;
$form = new Form();
?>


<?php ob_start(); ?>
<h1><?= $h1; ?></h1>

<?php if (!isset($ticket)): ?>

<div class="box-new">
    <?php require_once Systeme::root(1). 'HTML/Users/Support/New.php'; ?>
</div>

<?php else: ?>

<div class="box-ticket">
    <?php require_once Systeme::root(1). 'HTML/Users/Support/Ticket.php'; ?>
</div>

<?php endif; ?>
<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<?php if (isset($ticket)): ?>
<a href="/support"><p class="button-infos">Nouveau ticket</p></a>
<?php endif; ?>

<div class="box-all">
    <?php require_once Systeme::root(1). 'HTML/Users/Support/All.php'; ?>
</div>

<?php $contentRight = ob_get_clean(); ?>