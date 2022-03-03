<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-posts-index');
?>

<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="box-posts">
    <h2>Publiés</h2>
    <table>
        <tbody>
        <?php for ($i = 0; $i < count($posts); $i++): ?>  
            <?php if ($posts[$i]->state == 2): ?>   
            <tr>
                <td><?= $posts[$i]->title; ?></td>
                <td><a class="button-infos" href="/admin/posts/e/<?= $posts[$i]->id; ?>/unpublish">Retirer</a></td>
                <td><a class="button-warning" href="/admin/posts/e/<?= $posts[$i]->id; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/posts/e/<?= $posts[$i]->id; ?>/delete">Supprimer</a></td>
            </tr>
            <?php endif; ?>
        <?php endfor; ?>
        </tbody>
    </table>

    <h2>En attente</h2>
    <table>
        <tbody>
        <?php for ($i = 0; $i < count($posts); $i++): ?>  
            <?php if ($posts[$i]->state == 1): ?>   
            <tr>
                <td><?= $posts[$i]->title; ?></td>
                <td><a class="button-success" href="/admin/posts/e/<?= $posts[$i]->id; ?>/publish">Publier</a></td>
                <td><a class="button-warning" href="/admin/posts/e/<?= $posts[$i]->id; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/posts/e/<?= $posts[$i]->id; ?>/delete">Supprimer</a></td>
            </tr>
            <?php endif; ?>
        <?php endfor; ?>
        </tbody>
    </table>
</div>

<?php if (isset($requests)): ?>
<div class="box-requests">
    <h2>Requêtes des hauts gradés</h2>
    <div class="requests">
        <?php foreach ($requests as $data): ?>
        <p class="request">
            <span class="content"><?= $data->content; ?></span>
            <?php if ($data->title != null): ?>
            <span class="title">Titre de l'article: <?= $data->title; ?></span>
            <?php endif; ?>
            <span>- <?= $data->username; ?></span>
        </p>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<a class="button-infos" href="/admin/posts/new">Ajouter un nouvel article</a>

<div class="box-mine">
    <h2>Vos articles</h2>
    <table>
        <tbody>
        <?php for ($i = 0; $i < count($posts); $i++): ?>
            <?php if ($posts[$i]->idAuthorUser === $myId && $posts[$i]->state != 0): ?>
            <tr>
                <td><?= $posts[$i]->title; ?></td>
                <td><a class="button-warning" href="/admin/posts/e/<?= $posts[$i]->id; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/posts/e/<?= $posts[$i]->id; ?>/delete">Supprimer</a></td>
            </tr>
            <?php endif; ?>
        <?php endfor; ?>
        </tbody>
    </table>

    <h2>Vos brouillons</h2>
    <table>
        <tbody>
        <?php for ($i = 0; $i < count($posts); $i++): ?>
            <?php if ($posts[$i]->idAuthorUser === $myId && $posts[$i]->state == 0): ?>
            <tr>
                <td><?= $posts[$i]->title; ?></td>
                <td><a class="button-infos" href="/admin/posts/e/<?= $posts[$i]->id; ?>/send">Envoyer</a></td>
                <td><a class="button-warning" href="/admin/posts/e/<?= $posts[$i]->id; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/posts/e/<?= $posts[$i]->id; ?>/delete">Supprimer</a></td>
            </tr>
            <?php endif; ?>
        <?php endfor; ?>
        </tbody>
    </table>
</div>

<?php $contentRight = ob_get_clean(); ?>