<?php foreach ($allSec as $data): ?>

<a class="hover" href="<?= $data->link; ?>">
<div class="box-section">
    <div class="img" style="background-image: url('<?= $data->image; ?>');"></div>
    <p class="texts">
        <span class="name"><?= $data->name; ?></span>
        <span class="desc"><?= $data->description; ?></span>
    </p>
</div>
</a>

<?php endforeach; ?>