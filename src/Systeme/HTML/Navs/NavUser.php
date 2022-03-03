<?php
use Systeme\HTML\Users\Look;
use Systeme\HTML\Form;

$form = new Form();
?>

<div class="nav-user">
<?php if ($isLogged): ?>

    <div class="logged" onclick="myNavbar()" style="background-image: url(<?= Look::load($myDatas->look, ['ONLY' => true, 'FACE' => 'smile', 'HEADDIRECTION' => 'S']) ?>);"></div>
    <div class="drop">
        <a href="/users/parameters">
            <div class="parameters"></div>
        </a>

        <a href="/support">
            <div class="support"></div>
        </a>    

        <a href="/logout">
            <div class="logout"></div>
        </a>
    </div>

<?php else: ?>

    <div class="login" onclick="loginPop(true)">
        <img src="/img/navs/user/login.png" />
    </div>
    <div id="login">
        <div class="box">
            <form method="POST" action="/login">
                <?= $form->input([
                    'type' => 'text',
                    'name' => 'username',
                    'ph' => 'Username',
                    'required' => false
                ]); ?>
                <?= $form->input([
                    'type' => 'password',
                    'name' => 'password',
                    'ph' => 'Mot de passe',
                    'required' => false
                ]); ?>
                
                <div class="divided-2">
                    <?= $form->button(['name' => 'login',
                        'btn' => 'success', 
                        'text' => 'Connexion'
                    ]); ?>
                    <?= $form->button(['name' => 'navRegister',
                        'btn' => 'danger', 
                        'text' => 'Inscription'
                    ], '/register'); ?>
                </div>
            </form>
        </div>
    </div>
    
<?php endif ?>
</div>

<div id="myNavbar">
    <?php require_once Systeme::root(). 'Systeme/HTML/Navs/Dependencies/MyNavbar.php'; ?>
</div>