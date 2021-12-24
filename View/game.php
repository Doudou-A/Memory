<?php $title = 'Accueil' ?>
<?php $link = '<link rel="stylesheet" href="/public/style/css/accueil.css" />' ?>

    <div class="title">MEMORY GAME</div>
    <form class="formulary" action="index.php?action=game" method="POST">
        <?= htmlspecialchars($pseudo) ?>
        <input class="button" type="submit" name="valide" value="Jouer"/>
    </form>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>