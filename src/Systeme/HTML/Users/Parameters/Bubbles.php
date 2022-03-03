<h2 class="bubbles-default dropdown-arrow dropdown-open-dft">Bulles de chat</h2>
    
<div class="bubbles-default dropdown-dft">
<?php foreach ($bubbles as $bubble): ?>
        <?php if ($bubble->category === 'Default'): ?>
    <a <?= ($bubble->code === $all->bubble)? 'class="active"' : 'href="/users/parameters/b/' .$bubble->code. '"'; ?>>
        <div class="bubble bbl-<?= $bubble->code; ?>">
            <div class="head" style="background-image: url('<?= $all->look; ?>'), url('<?= $all->lookS; ?>');"></div>
            <p class="message"><span><?= $myDatas->username; ?>:</span> Message de test</p>
        </div>
    </a>
        <?php endif; ?>
<?php endforeach; ?>
</div>

<?php if ($all->vip || isset($all->rank)): ?>
<h2 class="bubbles-vip dropdown-arrow dropdown-open-vip">Bulles VIP</h2>

<div class="bubbles-vip dropdown-vip">
    <?php foreach ($bubbles as $bubble): ?>
        <?php if ($bubble->category === 'VIP'): ?>
    <a <?= ($bubble->code === $all->bubble)? 'class="active"' : 'href="/users/parameters/b/' .$bubble->code. '"'; ?>>
        <div class="bubble bbl-<?= $bubble->code; ?>">
            <div class="head" style="background-image: url('<?= $all->look; ?>'), url('<?= $all->lookS; ?>');"></div>
            <p class="message"><span><?= $myDatas->username; ?>:</span> Message de test</p>
        </div>
    </a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (isset($all->rank)): ?>
<h2 class="bubbles-staff dropdown-arrow dropdown-open-staff">Bulles STAFF</h2>

<div class="bubbles-staff dropdown-staff">
    <?php foreach ($bubbles as $bubble): ?>
        <?php if ($bubble->category === 'Staff'): ?>
    <a <?= ($bubble->code === $all->bubble)? 'class="active"' : 'href="/users/parameters/b/' .$bubble->code. '"'; ?>>
        <div class="bubble bbl-<?= $bubble->code; ?>">
            <div class="head" style="background-image: url('<?= $all->look; ?>'), url('<?= $all->lookS; ?>');"></div>
            <p class="message"><span><?= $myDatas->username; ?>:</span> Message de test</p>
        </div>
    </a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>