function onClickManage(json, aNumber) {
    var click = 0; //Compteur de click
    let firstClickImg;
    let obj = jQuery.parseJSON(json);// Récupération de l'objet contenant tous les fruits

    // Fonction qui gère l'affichage des cartes
    var flippingCard = function () {
        var id = $(this).data('id');
        var thisNameImg = obj[id];//Récupération du nom du fruit à partir de l'id de la div
        $(this).attr("src", "public/img/" + thisNameImg);// Affichage du fruit

        click += 1; // Incrémentation du clique

        if (click % 2) { // Si la valeur du click est impaire on sauvegarde les données du fruit dans un objet
            firstClickImg = {"number": id, "name": thisNameImg}
        } else { // Si la valeur du click est paire

            $(".image").unbind("click", flippingCard);// onClick bloqué pour éviter de retourner plus de deux cartes simultanément
            $(".image").removeClass("pointer");

            setTimeout(() => { // la fonction sera déclanché après un temps déterminé (dans les paramètre)
                if (thisNameImg != firstClickImg.name || id == firstClickImg.number) { // Si les fruits sont différents (ou click sur la même carte). Le(s) fruit(s) affiché(s) sont/est remplacé(s) par une carte grise
                    $(this).attr("src", "public/img/screen.png");
                    $("#" + firstClickImg.number).attr("src", "public/img/screen.png");

                    click -= 2;  // Les cartes ont été retournées, la valeur des deux clicks est donc soustraite au compteur

                } else { // Si le nombre de click est égale au nombre de fruit total, la partie est terminée
                    if (click == aNumber) {
                        alert("Vous avez gagnééééééé !")
                        window.location.href = "index.php?action=addGame&pseudo=" + $("#pseudo").html() + "&time=" + $("#gameTime").html();
                    }
                    ;
                }

                $(".image").bind("click", flippingCard);//Le onCLick est débloqué pour continuer la partie
                $(".image").addClass("pointer");
            }, 500);
        }
    }

    // Déclaration du onClick sur la fonction
    $(".image").bind("click", flippingCard);

}

function barProgressMove() {
    var width = 0;
    var gameTime = 0; // Chronomètre de la partie

    var time = setInterval(frame, 100);// La fonction frame est exécuté sur un intervalle de temps défini par le paramètre

    function frame() {
        if (width >= 100) {
            // Reset width et rechargement de la page pour une nouvelle partie
            clearInterval(time);
            alert("Vous avez perdu !!!!!!");
            location.reload();
        } else {
            // Incrémentation de la longueur de la barre de couleur et du temps
            width += 0.05;
            $("#myBar").width(width + "%");
            $("#myBar").html(parseInt(width) + "%");

            gameTime += 0.1;
            $("#gameTime").html(parseInt(gameTime)); // Insértion de la valeur dans la div
        }
    }
}