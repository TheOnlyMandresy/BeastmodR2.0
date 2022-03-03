<?php
define('TEMPLATE', 'Two');
define('PAGE', 'admin-ranks-rights');

use Systeme\HTML\Form;

$form = new form();
?>


<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<?php foreach (array_keys($all) as $key): ?>
<div class="box-rights">
    <h2><?= $key; ?></h2>
    <table>
        <tbody>
            <?php for ($i = 0; $i < count($all[$key]); $i++): ?>
            <tr>
                <td><?= $all[$key][$i]['id']; ?></td>
                <td><?= $all[$key][$i]['name']; ?></td>
                <td><?= $all[$key][$i]['description']; ?></td>
                <td><a class="button-warning" href="/admin/ranks/rights/e/<?= $all[$key][$i]['id']; ?>">Modifier</a></td>
                <td><a class="button-danger" href="/admin/ranks/rights/e/<?= $all[$key][$i]['id']; ?>/delete">Supprimer</a></td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>
<?php endforeach; ?>


<?php $contentLeft = ob_get_clean(); ?>


<?php ob_start(); ?>


<div class="box-new-right">
    <h2>Ajouter un droit</h2>
    <form method="POST" action="/admin/ranks/rights/new">
        <?= $form->input(['name' => 'name',
            'type' => 'text',
            'ph' => 'Nom du droit'
        ]); ?>
        <?= $form->textarea(['name' => 'description',
            'ph' => 'Description (facultatif)',
            'required' => false
        ], true); ?>  
        <?= $form->input(['name' => 'category',
            'type' => 'text',
            'ph' => 'Catégorie (facultatif)',
            'required' => false
        ]); ?>
        
        <div class="buttons">
            <button class="button-success">Ajouter</button>
        </div>
    </form>
</div>

<?php $contentRight = ob_get_clean(); ?>