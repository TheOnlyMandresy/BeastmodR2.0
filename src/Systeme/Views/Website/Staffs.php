<?php
define('TEMPLATE', 'Two');
define('PAGE', 'website-staffs');
?>
<?php ob_start(); ?>

<?php require_once Systeme::root(1). 'HTML/Staffs/Teams.php'; ?>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="box-about margin">
    <h2 class="dropdown-arrow dropdown-open-about">Pourquoi est-ce réparti ainsi ?</h2>

    <div class="content dropdown-about">
        <p>
            Dans nos rangs chaques responsables possèdent sa propre équipe. Les responsables peuvent êtres affectés au même pôle, mais ceux-ci ont pour but d'apporter à leur manière une touche personelle au pole affecté.
        </p>
        <p>
            Tous le monde ne possède pas la même vision des choses, c'est pourquoi une “multi-direction” permettra d'apporter plus de panache, en plus de la diversité d'esprit de leur équipe.
        </p>
    </div>
</div>

<div class="box-responsable margin">
    <?php require_once Systeme::root(1). 'HTML/Staffs/Manager.php'; ?>
</div>

<div class="box-responsable">
    <?php require_once Systeme::root(1). 'HTML/Staffs/Responsable.php'; ?>
</div>

<?php $contentRight = ob_get_clean(); ?>