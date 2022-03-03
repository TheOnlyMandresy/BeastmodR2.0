<?php
define('TEMPLATE', 'Two');
define('PAGE', 'community-search');

use Systeme\HTML\Form;
$form = new Form();
?>


<?php ob_start(); ?>

<div class="box-new">
    <?php require_once Systeme::root(1). 'HTML/Search/New.php'; ?>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box-research">
    <?php require_once Systeme::root(1). 'HTML/Search/New.php'; ?>
</div>

<?php if (isset($result)): ?>
<div class="box-result">
    <?php require_once Systeme::root(1). 'HTML/Search/Results.php'; ?>
</div>
<?php endif; ?>

<?php $contentRight = ob_get_clean(); ?>