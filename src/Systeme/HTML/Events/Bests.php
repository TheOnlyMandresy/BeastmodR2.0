<?php foreach ($allMighty as $data): ?>

    <a class="hover" href="<?= $data->link; ?>">
        <div class="box-best">
            <div class="img" style="background-image: url(<?= $allMighty[0]->look; ?>), url(<?= $allMighty[1]->look; ?>), url(<?= $allMighty[2]->look; ?>);"></div>

            <div class="infos">
                <p class="username"><?= $data->username; ?></p>

                <p class="points">
                    <span class="score"><?= $data->allEvents; ?></span>
                    <span class="text">Points</span>
                </p>
            </div>
        </div>
    </a>

<?php endforeach; ?>