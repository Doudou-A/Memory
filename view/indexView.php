<?php $title = 'Accueil' ?>
<?php $link = '<link rel="stylesheet" href="/public/style/css/accueil.css" />' ?>

<?php
ob_start();
?>

    <form class="formulary" action="index.php?action=displayGame" method="POST">
        <input class="input" type="text" name="pseudo" placeholder="Pseudo" required="required"/>
        <input class="button" type="submit" name="valide" value="Jouer"/>
    </form>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>