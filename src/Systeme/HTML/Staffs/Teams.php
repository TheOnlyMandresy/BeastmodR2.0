<?php foreach ($all as $dataResponsable): ?>
    <?php if ($dataResponsable->responsable == 1 && $dataResponsable->idRights !== 'all'): ?>

<div class="box-team margin">
    <h2 <?= ($dataResponsable->teammates)? 'class="dropdown-arrow dropdown-open-' .$dataResponsable->username. ' open"' : null; ?>>
        <img src="<?= $dataResponsable->look; ?>" /> Team <?= $dataResponsable->username; ?>
    </h2>

    <div class="team <?= ($dataResponsable->teammates)? 'dropdown-' .$dataResponsable->username : null; ?>">
    <?php foreach ($all as $dataStaff): ?>
        <?php if ($dataStaff->idSuperiorUser === $dataResponsable->idUser): ?>
    
    <div class="staff">
            <div class="img"><img src="<?= $dataStaff->look; ?>" /></div>
            <p class="username">
                <a href="<?= $dataStaff->link; ?>"><?= $dataStaff->username; ?></a>
            </p>
            <p class="infos">
                <span class="fonction">fonction: <?= $dataStaff->name; ?></span>
                <?php if ($dataStaff->description != null): ?>
                <span class="description">rôle: <?= $dataStaff->description; ?></span>
                <?php endif; ?>
            </p>
        </div>

        <?php endif; ?>
    <?php endforeach; ?>
    </div>
</div>

    <?php endif; ?>
<?php endforeach; ?>