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
                if (thisNameImg != firstClickImg.name) { // Si les fruits sont différents. Les deux fruits affichés sont remplacés par une carte grise
                    $(this).attr("src", "public/img/screen.png");
                    $("#" + firstClickImg.number).attr("src", "public/img/screen.png");

                    click -= 2;  // Les cartes ont été retournées, la valeur des deux clicks est donc soustraite au compteur

                } else { // Si le nombre de click est égale au nombre de fruit total, la partie est terminée
                    click == aNumber ? alert("Vous avez gagnééééééé ! Vous avez terminé la partie en " + $("#gameTime").html()) : null;
                }

                $(".image").bind("click", flippingCard);//Le onCLick est débloqué pour continuer la partie
                $(".image").addClass("pointer");
            }, 1000);
        }
    }

    // Déclaration du onClick sur la fonction
    $(".image").bind("click", flippingCard);

}

function barProgressMove() {
    var width = 0;
    var gameTime // Chronomètre de la partie
    var mill = 0;
    var sec = 0;
    var stringSec;
    var min = 0;

    var time = setInterval(frame, 100);// La fonction frame est exécuté sur un intervalle de temps défini par le paramètre

    function frame() {
        if (width >= 100) {
            // Reset width et rechargement de la page pour une nouvelle partie
            clearInterval(time);
            alert("Vous avez perdu !!!!!!");
            location.reload();

        } else {
            // Incrémentation de la longueur de la barre de couleur et du temps
            width += 0.02;
            $("#myBar").width(width + "%");

            mill++;
            if (mill >= 10) {
                mill = 0;
                sec++;
                if (sec >= 60) {
                    sec = 0;
                    min++;
                }
            }

            sec < 10  ? stringSec = "0"+sec : stringSec = +sec; // ajoût d'un 0 si la valeur de sec est entre 0 et 10

            gameTime = min + ":" + stringSec;
            $("#gameTime").html(gameTime); // Insértion de la valeur dans la div
        }
    }
}