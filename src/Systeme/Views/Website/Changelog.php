<?php
define('TEMPLATE', 'One');
define('PAGE', 'index-changelog');

?>

<?php ob_start(); ?>
<h1><?= $h1; ?></h1>

<?php foreach ($dates as $key => $date): ?>

<div class="box-changelog margin padding">
    <h2>[<?= $date; ?>]</h2>

    <ul>
    <?php foreach ($datas as $data): ?>
        <?php if ($data->date == $date): ?>
        <li><?= $data->changes; ?></li>
        <?php endif; ?>
    <?php endforeach; ?>
    </ul>
</div>

<?php endforeach; ?>

<?php $contentOne = ob_get_clean(); ?>