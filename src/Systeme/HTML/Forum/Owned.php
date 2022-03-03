<h2 class="dropdown-arrow dropdown-open-owned">Mes topics</h2>

<?php if ($myTopics): ?>
<div class="dropdown-owned">
    <div class="owned">
<?php foreach ($myTopics as $data): ?>

    <div class="box-owned padding">
        <p class="title"><?= $data->title; ?></p>
        <p class="date"><?= $data->createAt; ?></p>

        <div class="buttons">
            <a href="<?= $data->link; ?>">
                <div class="button-infos">Voir</div>
            </a>
            
            <a href="<?= $data->edit; ?>">
                <div class="button-warning">Modifier</div>
            </a>

            <?php if ($data->state == 1): ?>
                <a href="<?= $data->close; ?>">
                    <div class="button-danger">Fermer</div>
                </a>
            <?php else: ?>
                <a href="<?= $data->open; ?>">
                    <div class="button-success">Ouvrir</div>
                </a>
            <?php endif; ?>
        </div>
    </div>

<?php endforeach; ?>
    </div>
</div>
<?php endif; ?>


<h2 class="dropdown-arrow dropdown-open-followed open">Topics que vous suivez</h2>

<?php if ($myTopicsFollowed): ?>
<div class="dropdown-followed">
    <div class="owned">
<?php foreach ($myTopicsFollowed as $data): ?>

    <div class="box-owned padding">
        <p class="title"><?= $data->title; ?></p>
        <p class="date"><?= $data->createAt; ?></p>

        <div class="buttons">
            <a href="<?= $data->link; ?>">
                <div class="button-infos">Voir</div>
            </a>
        </div>
    </div>

<?php endforeach; ?>
    </div>
</div>
<?php endif; ?>


<h2 class="dropdown-arrow dropdown-open-commented">Topics que vous avez commenté</h2>

<div class="dropdown-commented">
    <div class="owned">
<?php for ($i = 0; $i < count($myTopicsCommented); $i++): ?>

    <div class="box-owned padding">
        <p class="title"><?= $myTopicsCommented[$i]->title; ?></p>
        <p class="date"><?= $myTopicsCommented[$i]->createAt; ?></p>

        <div class="buttons">
            <a href="<?= $myTopicsCommented[$i]->link; ?>">
                <div class="button-infos">Voir</div>
            </a>
        </div>
    </div>

<?php endfor; ?>
    </div>
</div>