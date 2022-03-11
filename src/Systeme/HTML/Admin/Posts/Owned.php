<h2 class="dropdown-arrow dropdown-open-ownPublic">Vos articles</h2>

<div class="celled dropdown-ownPublic">
<?php for ($i = 0; $i < count($posts); $i++): ?>
    <?php if ($posts[$i]->idAuthorUser === $myId && $posts[$i]->state != 0): ?>
    <div class="cell-2">
        <p><?= $posts[$i]->title; ?></p>

        <a href="/admin/posts/e/<?= $posts[$i]->id; ?>">
            <p class="button-warning">Modifier</p>
        </a>

        <a href="/admin/posts/e/<?= $posts[$i]->id; ?>/delete">
            <p class="button-danger">Supprimer</p>
        </a>
    </div>
    <?php endif; ?>
<?php endfor; ?>
</div>

<h2 class="dropdown-arrow dropdown-open-ownPrivate open">Vos brouillons</h2>

<div class="celled dropdown-ownPrivate">
<?php for ($i = 0; $i < count($posts); $i++): ?>
    <?php if ($posts[$i]->idAuthorUser === $myId && $posts[$i]->state == 0): ?>
    <div class="cell-3">
        <p><?= $posts[$i]->title; ?></p>

        <a href="/admin/posts/e/<?= $posts[$i]->id; ?>/send">
            <p class="button-infos">Envoyer</p>
        </a>

        <a href="/admin/posts/e/<?= $posts[$i]->id; ?>">
            <p class="button-warning">Modifier</p>
        </a>

        <a href="/admin/posts/e/<?= $posts[$i]->id; ?>/delete">
            <p class="button-danger">Supprimer</p>
        </a>
    </div>
    <?php endif; ?>
<?php endfor; ?>
</div>