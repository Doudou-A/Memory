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


    <script type="text/javascript">
        $(document).ready(function () {
            //Compteur de click
            var click = 0;

            // Déclaration de l'objet. Il contiendra les données du premier fruit affiché afin de les comparer aux données du deuxième fruit.
            let firstClickImg;

            // Récupération de l'objet (contenant tous les fruits) en faisant un parse sur le Json
            let obj = jQuery.parseJSON('<?= $myJson; ?>');


            // Fonction qui gère l'affichage des cartes
            var flippingCard = function() {
                //id de la div qui correspond à un fruit possédant le même id dans l'objet
                var id = $(this).data('id');

                //Récupération du nom du fruit à partir de l'id de la div
                var thisNameImg = obj[id];

                // Affichage de la carte en modifiant la donnée src de la div. La carte grise est remplacé par le fruit
                $(this).attr("src", "public/img/" + thisNameImg);

                //Incrémentation du compteur
                click += 1;

                if (click % 2) { // Si la valeur du click est impaire on sauvegarde les données du fruit dans un objet
                    firstClickImg = {"number": id, "name": thisNameImg}
                } else { // Si la valeur du click est paire

                    // Le onClick est bloqué pour éviter de retourner plus de deux cartes simultanément
                    $(".image").unbind( "click", flippingCard );
                    $(".image").removeClass("pointer");

                    setTimeout(() => { // la fonction sera déclanché après un temps déterminé dans les paramètres de la fonction
                        if (thisNameImg != firstClickImg.name) { // Si les fruits sont différents. Les deux fruits affichés sont remplacés par une carte grise

                            $(this).attr("src", "public/img/screen.png");
                            $("#" + firstClickImg.number).attr("src", "public/img/screen.png");

                            // Les cartes ont été retourné, la valeur des deux clicks est donc soustraite au compteur
                            click -= 2;
                        }

                        //Le onCLick est débloqué pour continuer la partie
                        $(".image").bind( "click", flippingCard );
                        $(".image").addClass("pointer");
                    }, 2000);
                }
            }

            // Déclaration du onClick sur la fonction
            $( ".image" ).bind( "click", flippingCard );

        });
    </script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>