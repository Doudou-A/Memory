<?php $title = 'Jeu'; ?>
<?php $link = '<link rel="stylesheet" href="/public/style/css/game.css" />'; ?>

<?php
ob_start();
?>
    <!-- Le JSON créé depuis le controller. C'est nécessaire de l'insérer dans le block html afin d'être utiliser dans le block Javascript -->
    <div style="display: none"><?= $myJson; ?></div>
    <div id="gameTime" style="display: none">0</div> <!-- Chronomètre du jeu -->

    <!-- Nom du Joueur  -->
    <div>
        Le joueur : <?= htmlspecialchars($pseudo); ?>
    </div>


    <div class="plateau">
    <!-- On boucle le nombre de fois qu'il a de fruit  -->
        <?php for ($i = 0; $i < $aNumber; $i++) : ?>
            <!-- On affiche autant de carte grise que de fruit dans le jeu -->
            <img id="<?= $i; ?>" data-id="<?= $i; ?>" class="image pointer" src="public/img/screen.png" width="9%"/>
        <?php endfor ?>
    </div>

    <!-- Barre de progression global-->
    <div id="myProgress">
        <!-- Barre de couleur qui s'agrandit par la fonction barProgressMove()x -->
        <div id="myBar"></div>
    </div>

    <script type="text/javascript">
        //Fonction qui gère les fonctionnalitées liées au onClick sur une carte grise
        onClickManage('<?= $myJson; ?>', '<?= $aNumber; ?>');

        //Fonction associée à la barre de progression
        barProgressMove();
    </script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>