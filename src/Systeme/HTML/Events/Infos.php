
<div class="buttons-container link">
<?php if ($start > time() || $end <= time()): ?>
    <a class="button-success active">Allez-y</a>
<?php else: ?>   
    <a href="<?= $data->appartUrl; ?>" target="_blank" class="button-success">Allez-y</a>
<?php endif; ?>
</div>


<?php if ($start > time()): ?>
    <p class="countdown">Bientôt</p>
<?php elseif ($start <= time() && $end > time()): ?>
    <p class="countdown">En cours</p>
<?php elseif ($end <= time()): ?>   
    <p class="countdown"><?= Systeme::specialUcFirst('événement terminer'); ?></p>
<?php endif; ?>


<div class="dates">
    <p class="start"><span>Du :</span> <span><?= $data->startAt; ?></span></p>
    <p class="end"><span>Au:</span> <span><?= $data->endAt; ?></span></p>
</div>