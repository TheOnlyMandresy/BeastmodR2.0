<?php foreach ($allMonth as $data): ?>

    <a class="hover" href="<?= $data->link; ?>">
        <div class="user">
            <div class="img">
                <img src="<?= $data->look; ?>" />
            </div>
            
            <p class="username"><?= $data->username; ?></p>
            <p class="points"><?= $data->monthEvents; ?> Pts</p>
        </div>
    </a>

<?php endforeach; ?>