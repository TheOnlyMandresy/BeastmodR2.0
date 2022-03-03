<h2>Récompenses</h2>

<?php if ($data->rewards != null): ?>
<p class="content"><?= $data->rewards; ?></p>
<?php endif; ?>

<ul class="rewards">

    <li class="price">
        <p class="toWin"><?= $data->first; ?></p>
        <?php if (isset($data->firstPlaceUsername)): ?>
        <p class="winner" style="background-image: url('<?= $data->firstPlaceLook; ?>'), url(/img/top_3_1.png);"><?= $data->firstPlaceUsername; ?></p>
        <?php endif; ?>
    </li>

    <li class="price">
        <p class="toWin"><?= $data->second; ?></p>
        <?php if (isset($data->secondPlaceUsername)): ?>
        <p class="winner" style="background-image: url('<?= $data->secondPlaceLook; ?>'), url(/img/top_3_2.png);"><?= $data->secondPlaceUsername; ?></p>
        <?php endif; ?>
    </li>

    <li class="price">
        <p class="toWin"><?= $data->third; ?></p>
        <?php if (isset($data->thirdPlaceUsername)): ?>
        <p class="winner" style="background-image: url('<?= $data->thirdPlaceLook; ?>'), url(/img/top_3_3.png);"><?= $data->thirdPlaceUsername; ?></p>
        <?php endif; ?>
    </li>
</ul>

<?php if ($data->others != null): ?>
<p class="participate">Participation: <?= $data->others; ?></p>
<?php endif; ?>