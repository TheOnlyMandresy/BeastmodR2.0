<h2>Infos compte</h2>

<p class="certified">
    <span class="title">Statut compte : </span>
    <?= ($all->certified)? 'Certifié' : 'Non certifié'; ?>
</p>
<p class="rank">
    <span class="title">Rang :</span>
    <?php
        if (isset($all->rank)) {
            echo $all->rank;
        } else {
            echo ($all->vip)? 'VIP' : 'Membre';
        }
        echo ' - ' .$all->sub;
    ?>
</p>
<p class="gender">
    <span class="title">Sexe :</span>
    <?= ($all->gender)? 'Féminin' : 'Masculin'; ?>
</p>
<p class="connexion">
    <span class="title">Dernière connexion :</span>
    <?= $all->last; ?>
</p>
<p class="creation">
    <span class="title">Créer le :</span>
    <?= $all->createAt; ?>
</p>