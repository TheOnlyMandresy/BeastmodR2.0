<?php foreach ($events as $event): 
    $start = Systeme::dateFormat('timestamp', $event->startAt);
    $end = Systeme::dateFormat('timestamp', $event->endAt);
?>
    <div class="box-event">
        <div class="img" style="background-image: url('<?= $event->background; ?>');"></div>
        <p class="title"><?= $event->title; ?></p>

        <?php if ($start > time()): ?>
        <p class="countdown" title="<?= $event->appartUrl; ?>"><?= Systeme::dateFormat('timestamp', $event->startAt); ?></p>
        <?php elseif ($start <= time() && $end > time()): ?>
        <p class="countdown"><?= Systeme::specialUcFirst('en cours'); ?></p>
        <?php elseif ($end <= time()): ?>   
        <p class="countdown"><?= Systeme::specialUcFirst('événement terminer'); ?></p>
        <?php endif; ?>

        <div class="buttons">

        <?php if ($start > time() || $end <= time()): ?>
            <a class="button-success active" target="_blank">Allez-y</a>
        <?php else: ?>   
            <a href="<?= $event->appartUrl; ?>" target="_blank" class="button-success">Y aller (A)</a>
        <?php endif; ?>
            <a href="<?= $event->link; ?>" class="button-infos">i</a>
        
        </div>
    </div>
<?php endforeach; ?>

<div class="box-plus buttons-container">
    <a href="/events" class="button-base">plus</a>
</div>