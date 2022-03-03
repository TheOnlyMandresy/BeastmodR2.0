<?php
define('TEMPLATE', 'Two');
define('PAGE', 'community-forum-new');

?>
<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<?php
if (!isset($edit)) {
    require_once Systeme::root(1). 'HTML/Forum/New.php';
} else {
    require_once Systeme::root(1). 'HTML/Forum/Edit.php';
}
?>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<?php if ($isLogged) { require_once Systeme::root(1). 'HTML/Forum/Owned.php'; } ?>

<?php $contentRight = ob_get_clean(); ?>