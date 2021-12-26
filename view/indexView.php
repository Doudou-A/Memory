<?php $title = 'Accueil' ?>
<?php $link = '<link rel="stylesheet" href="/public/style/css/accueil.css" />' ?>

<?php
ob_start();
?>
    <!-- FORMULAIRE-->
    <form class="formulary" action="index.php?action=displayGame" method="POST">
        <input class="input" type="text" name="pseudo" placeholder="Pseudo" required="required"/>
        <input class="button" type="submit" name="valide" value="Jouer"/>
    </form>

    <!-- CLASSEMENT -->
    <div class="ranking">
        <div class="classement">Classement</div>
        <?php if ($bestScore) : ?>
            <?php foreach ($bestScore as $key => $score) : ?> <!-- Boucle sur les 5 meilleurs scores -->
                <div class="score <?php if ($key == 0) : ?> frstRank <?php elseif ($key == 1) : ?> scdRank <?php elseif ($key == 2) : ?> trdRank <?php endif; ?>"> <!-- Changement de la classe selon la position dans le classement-->
                    <div class="dataRank pseudoRank"><?= htmlspecialchars($score["pseudo"]); ?></div>
                    <div class="dataRank timeRank"><?= $score["time"]; ?></div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="notRank">Soyez le premier à jouer</div>
        <?php endif; ?>
    </div>

<?php $content = ob_get_clean(); ?>

<!-- TEMPLATE de l'application contenant les éléments communs à toutes les view-->
<?php require('template.php'); ?>