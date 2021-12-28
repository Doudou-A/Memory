<?php $title = 'Jeu'; ?>
<?php $link = '<link rel="stylesheet" href="/public/style/css/game.css" />'; ?>

<?php
ob_start();
?>
    <!-- Le JSON créé depuis le controller. C'est nécessaire de l'insérer dans le block html afin d'être utiliser dans le block Javascript -->
    <div style="display: none"><?= $myJson; ?></div>
    <div id="chrono" style="display: none">1</div> <!-- Chronomètre du jeu en seconde -->

    <!-- NOM DU JOUEUR  -->
    <div style="display: flex; font-size: 20px; margin: 30px">
        Le joueur :
        <div id="pseudo"><?= htmlspecialchars($pseudo); ?></div>
    </div>


    <!-- PLATEAU DE JEU -->
    <div class="plateau">
        <!-- On boucle le nombre de fois qu'il a de fruit  -->
        <?php for ($i = 0; $i < $aNumber; $i++) : ?>
            <img id="<?= $i; ?>" data-id="<?= $i; ?>" class="image imageClick pointer" src="public/img/screen.png" width="9%"/>
        <?php endfor ?>
    </div>

    <!-- CHRONOMETRE AFFICHE -->
    <div id="gameTime">0</div>

    <!-- BARRE DE PROGRESSION -->
    <div id="myProgress">
        <!-- Barre de couleur dont la taille augmente au fil du temps par la fonction barProgressMove() -->
        <div id="myBar">0%</div>
    </div>

    <script type="text/javascript">
        //Fonction qui gère les fonctionnalitées liées au onClick sur une carte grise + la fin du jeu
        onClickManage('<?= $myJson; ?>', '<?= $aNumber; ?>');

        //Fonction associée à la barre de progression
        barProgressMove();
    </script>

<?php $content = ob_get_clean(); ?>

    <!-- TEMPLATE de l'application contenant les éléments communs à toutes les view-->
<?php require('template.php'); ?>