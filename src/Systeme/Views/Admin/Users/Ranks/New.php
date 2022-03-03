<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-ranks-new');

use Systeme\HTML\Form;

$form = new form();
?>


<?php ob_start(); ?>
<?php if (!isset($edit)): ?>
<h1><?= $h1; ?></h1>

<div class="box-new">
    <form method="POST" action="/admin/ranks/new/create">
        <?= $form->input(['name' => 'idUser',
            'type' => 'text',
            'ph' => 'Pseudo du joueur'
        ]); ?>
        <?= $form->input(['name' => 'name',
            'type' => 'text',
            'ph' => 'Nom du rôle'
        ]); ?>
        <?= $form->textarea(['name' => 'description',
            'ph' => 'Description (facultatif)',
            'required' => false
        ], true); ?>
        
        <?php if ($myDatas->manager): ?>
            <?= $form->input(['name' => 'responsable',
                'type' => 'checkbox',
                'required' => false,
                'value' => 1,
                'ph' => 'Est-il un responsable ?'
            ]); ?>
        <?php endif; ?>

        <h2>Les droits</h2>
        <div class="rights">
            <?php foreach (array_keys($rights) as $key): ?>
            <div class="box right" id="rights-<?= $key; ?>">
                <h3><?= $key; ?></h3>
                <div class="selectAll button-base" onclick="checkAll('<?= $key; ?>', true)">Tous</div>

                <?php for ($i = 0; $i < count($rights[$key]); $i++): ?>
                <div class="right">
                    <p class="title"><?= $rights[$key][$i]['name']; ?></p>
                    <?= $form->input(['name' => 'idRights[]',
                        'type' => 'checkbox',
                        'required' => false,
                        'value' =>$rights[$key][$i]['id'],
                        'ph' => $rights[$key][$i]['description']
                    ]); ?>
                </div>
                <?php endfor; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="buttons">
            <button class="button-success">Ajouter</button>
        </div>
    </form>
</div>
<?php elseif (isset($edit)): ?>
<h1><?= $h1; ?></h1>

<div class="box-edit">
    <form method="POST" action="/admin/ranks/e/<?= $data->id; ?>/edit">
        <?= $form->input(['name' => 'name',
            'type' => 'text',
            'ph' => 'Nom du rôle',
            'value' => $data->name]
            ); ?>
        <?= $form->textarea(['name' => 'description',
            'ph' => 'Description (facultatif)',
            'required' => false,
            'value' => $data->description
            ], true); ?>
        
        <?php if ($myDatas->manager): ?>
        <?= $form->input(['name' => 'responsable',
            'type' => 'checkbox',
            'required' => false,
            'value' => 1,
            'ph' => 'Est-il un responsable ?',
            'checked' => $resp
            ]); ?>
        <?php endif; ?>

        <h2>Les droits</h2>
        <div class="rights">
            <?php foreach (array_keys($rights) as $key): ?>
            <div class="box right" id="rights-<?= $key; ?>">
                <h3><?= $key; ?></h3>
                <div class="selectAll button-base" onclick="checkAll('<?= $key; ?>', true)">Tous</div>

                <?php for ($i = 0; $i < count($rights[$key]); $i++): ?>
                    <?php $checked = (in_array($rights[$key][$i]['id'], $data->idRights))? true : false; ?>
                <div class="right">
                    <p class="title"><?= $rights[$key][$i]['name']; ?></p>
                    <?= $form->input(['name' => 'idRights[]',
                        'type' => 'checkbox',
                        'required' => false,
                        'value' =>$rights[$key][$i]['id'],
                        'ph' => $rights[$key][$i]['description'],
                        'checked' => $checked
                        ]); ?>
                </div>
                <?php endfor; ?>
            </div>
            <?php endforeach; ?>
        </div>
          
        <div class="buttons">
            <button class="button-success">Modifier</button>
        </div>
    </form>
</div>
<?php endif; ?>

<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>

<?php $contentRight = ob_get_clean(); ?>