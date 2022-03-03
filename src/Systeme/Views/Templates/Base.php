<!-- 

┏━━┓︱┏━━━┓ ┏━━━┓ ┏━━━┓ ┏━━━━┓  ┏━┓┏━┓ ┏━━━┓ ┏━━━┓  ︱ ┏━━━┓ ┏━┓┏━┓ ┏━━━┓
┃┏┓┃︱┃┏━━┛ ┃┏━┓┃ ┃┏━┓┃ ┃┏┓┏┓┃  ┃┃┗┛┃┃ ┃┏━┓┃ ┗┓┏┓┃  ︱ ┃┏━┓┃ ┃┃┗┛┃┃ ┃┏━┓┃
┃┗┛┗┓ ┃┗━━┓ ┃┃ ┃┃ ┃┗━━┓ ┗┛┃┃┗┛︱┃┏┓┏┓┃ ┃┃ ┃┃  ┃┃┃┃  ︱ ┃┃ ┗┛ ┃┏┓┏┓┃ ┃┗━━┓
┃┏━┓┃ ┃┏━━┛ ┃┗━┛┃ ┗━━┓┃ ︱┃┃︱︱┃┃┃┃┃┃ ┃┃ ┃┃  ┃┃┃┃  ︱ ┃┃ ┏┓ ┃┃┃┃┃┃ ┗━━┓┃
┃┗━┛┃ ┃┗━━┓ ┃┏━┓┃ ┃┗━┛┃ ︱┃┃︱︱┃┃┃┃┃┃ ┃┗━┛┃ ┏┛┗┛┃  ︱ ┃┗━┛┃ ┃┃┃┃┃┃ ┃┗━┛┃
┗━━━┛ ┗━━━┛ ┗┛ ┗┛ ┗━━━┛ ︱┗┛︱︱┗┛┗┛┗┛ ┗━━━┛ ┗━━━┛  ︱ ┗━━━┛ ┗┛┗┛┗┛ ┗━━━┛

                    █▀▀█ █▀▀█ █▀▀ █▀▀ █▀▀ █▀▀▄ ▀▀█▀▀
                    █░░█ █▄▄▀ █▀▀ ▀▀█ █▀▀ █░░█ ░░█░░
                    █▀▀▀ ▀░▀▀ ▀▀▀ ▀▀▀ ▀▀▀ ▀░░▀ ░░▀░░
                            The version R2.0
-->

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?= $title; ?></title>
    <link rel="stylesheet" href="/css/css/structure.css" />
    <link rel="stylesheet" href="/plugins/sceditor-3.1.1/development/themes/kamobbah.css" />

    <script type = "text/javascript" src="/js/base.js"></script>
    <script src="/plugins/sceditor-3.1.1/development/sceditor.js"></script>
    <script src="/plugins/sceditor-3.1.1/development/formats/bbcode.js"></script>
</head>

<body class="<?= PAGE; ?>">
    <?php if (isset($_SESSION['flash'])): ?>
    <div class="flash">
        <div class="blur"></div>
        <p class="content-<?= $_SESSION['flash']['type']; ?>">
            <?= $_SESSION['flash']['message']; ?>
        </p>
    </div>
    <?php endif; ?>

    <div class="template<?= TEMPLATE; ?>">
        <?= $body; ?>
    </div>

    <?php require_once 'Nav.php'; ?>
    
    <footer>
        <?php require_once 'Footer.php'; ?>
    </footer>

    <?php require_once 'Loading.php'; ?>
    <?= $js; ?>
</body>

</html>

<!-- 
.------.
|K.--. |
| :/\: |
| :\/: |
| '--'H|
`------'
-->