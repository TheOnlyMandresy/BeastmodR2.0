<?php
define('TEMPLATE', 'Two');
define('PAGE', 'others-events');
?>


<?php ob_start(); ?>

<div class="all">
    <?php require_once Systeme::root(1). 'HTML/Events/All.php'; ?>
</div>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<div class="bests margin">
    <?php require_once Systeme::root(1). 'HTML/Events/Bests.php'; ?>
</div>

<div class="box-about margin">
    <h2 class="dropdown-arrow dropdown-open-about">A propos</h2>
    <div class="content dropdown-about">
        <p>
            Les événements sont l'une des attractions que le site te propose. Cette activitée est plus sociale que les autres car elles sont directements animées par nos Staffs avec la communauté.
        </p>
        <p>
            <span class="question">Pourquoi y participer ?</span>
            <span class="answer">
                Généralement pour le fun que peut apporter la diversité de nos événements. Mais pour les compétiteurs et les personnages en quêtes de biens, il y a par défaut pour chaque participant 5 points de plus pour le classement. +5 à +15 pour le Top 3.
                <br />
                A savoir, le Top 3 gagne non seulement des points en plus au classement, mais aussi des récompenses spéciales par événements. - Parfois, les participants aussi, alors ne vous découragez pas eheh...
            </span>
        </p>
        <p>
            <span class="question">Et le classement ?</span>
            <span class="answer">
                Pour le classement, il n'y a pas plus que la fame (loi du plus fort). Un jour peut-être, il y aura des lots par saisons, qui sait ?
                <br />
                Le classement quant à lui, est réinitialisé tous les mois. Sauf le Top 3, qui représente les 3 meilleurs de tous les temps.  
            </span>
        </p>
    </div>
</div>

<div class="box-top">
    <h2>Classement (Top 10)</h2>
    
    <div class="top">
        <?php require_once Systeme::root(1). 'HTML/Events/Top.php'; ?>
    </div>
</div>

<?php $contentRight = ob_get_clean(); ?>