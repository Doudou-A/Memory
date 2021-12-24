<?php $title = 'Accueil' ?>
<?php $link = '<link rel="stylesheet" href="/public/style/css/game.css" />' ?>

        <div>
            Le joueur : <?= htmlspecialchars($pseudo) ?>
        </div>

        <div class="plateau">
            <?php 	foreach ($aImage as $key => $image) :?>
                <img class="image" src="public/img/<?=$image?>" width="9%">
            <?php 	endforeach ?>
    </div>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>