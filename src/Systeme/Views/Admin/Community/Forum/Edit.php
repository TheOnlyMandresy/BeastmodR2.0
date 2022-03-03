<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-index');
?>
<?php ob_start(); ?>

<div class="box">
<h1>[ADMINISTRATION] Accueil</h1>
<p>Cette page contient tous les contributeurs au bel avancement du site.</p>
</div>

<?php $contentTop = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box">
<h2>GAUCHE</h2>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<h2>RIGHT</h2>

<?php $contentRight = ob_get_clean(); ?>