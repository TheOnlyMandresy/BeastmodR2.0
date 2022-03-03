<?php foreach ($sections as $data): ?>
    <?php if ((isset($section) && $data->name !== $section->name) || !isset($section)): ?>

<a class="hover" href="<?= $data->link; ?>">
    <div class="category-<?= $data->name; ?>">
        <div class="buttons-container img"></div>
        <p class="name"><?= $data->name; ?></p>
    </div>
</a>

    <?php endif; ?>
<?php endforeach; ?>

<?php if (isset($section)): ?>

<a class="hover" href="/posts">
    <div class="category-all">
        <div class="buttons-container img"></div>
        <p class="name">Tous</p>
    </div>
</a>

<?php endif; ?>