<h2>Vos tickets</h2>

<?php foreach ($all as $data): ?>
<a href="/support/<?= $data->id; ?>">
    <div class="ticket">
        <p class="title">
            <span class="state">
            [
            <?php
            if ($data->state == 0) {
                echo 'FERMÉ';
            } elseif ($data->state == 1 || $data->state == 2) {
                echo 'EN ATTENTE';
            } elseif ($data->state == 3) {
                echo 'RÉPONDU';
            }
            ?>
            ]
            </span>
            <?= $data->title; ?>
        </p>
        <p class="date">Ouvert le: <?= $data->createAt; ?></p>
    </div>
</a>
<?php endforeach; ?>