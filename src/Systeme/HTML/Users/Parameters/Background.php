<h2>Background</h2>

<div class="background" style="background-image: url('<?= $all-> background; ?>');">
    <form method="POST" enctype="multipart/form-data">
        <?= $form->input(['name' => 'image',
            'type' => 'file',
            'accept' => 'image/*'
        ]); ?>

        <div class="buttons-container">
            <?= $form->button(['name' => 'param-bg',
                'btn' => 'success', 
                'text' => 'Sauvegarder'
            ]); ?>
        </div>
    </form>
</div>