<h2 class="dropdown-arrow dropdown-open-publics">Publiés</h2>

<div class="celled dropdown-publics">
<?php for ($i = 0; $i < count($posts); $i++): ?>  
    <?php if ($posts[$i]->state == 2): ?>   
    <div class="cell-3">
        <p><?= $posts[$i]->title; ?></p>

        <a href="/admin/posts/e/<?= $posts[$i]->id; ?>/unpublish">
            <p class="button-infos">Retirer</p>
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

<h2 class="dropdown-arrow dropdown-open-waiting open">En attente</h2>

<div class="celled dropdown-waiting">
<?php for ($i = 0; $i < count($posts); $i++): ?>  
    <?php if ($posts[$i]->state == 1): ?>   
    <div class="cell-3">
        <p><?= $posts[$i]->title; ?></p>

        <a href="/admin/posts/e/<?= $posts[$i]->id; ?>/publish">
            <p class="button-success">Publier</p>
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