<?php $title = 'Jeu'; ?>
<?php $link = '<link rel="stylesheet" href="/public/style/css/game.css" />'; ?>

<?php
ob_start();
?>
    <!-- Le JSON créé depuis le controller. C'est nécessaire de l'insérer dans le block html afin d'être utiliser dans le block Javascript -->
    <div style="display: none"><?= $myJson; ?></div>


    <!-- Nom du Joueur  -->
    <div>
        Le joueur : <?= htmlspecialchars($pseudo); ?>
    </div>


    <div class="plateau">
    <!-- On boucle le nombre de fois qu'il a de fruit  -->
        <?php for ($i = 0; $i < $aNumber; $i++) : ?>
            <!-- On affiche autant de carte griss que de fruit dans le jeu -->
            <img id="<?= $i; ?>" data-id="<?= $i; ?>" class="image pointer" src="public/img/screen.png" width="9%"/>
        <?php endfor ?>
    </div>

    <div id="myProgress">
        <div id="myBar"></div>
    </div>

    <script type="text/javascript">
        onClickManage('<?= $myJson; ?>', '<?= $aNumber; ?>');
        barProgressMove();
    </script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>