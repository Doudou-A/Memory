<?php $title = 'Accueil' ?>
<?php $link = '<link rel="stylesheet" href="/public/style/css/accueil.css" />' ?>

    <form class="formulary" action="index.php?action=game" method="POST">
        <input class="input" type="text" name="pseudo" placeholder="Pseudo" required="required"/>
        <input class="button" type="submit" name="valide" value="Jouer"/>
    </form>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>