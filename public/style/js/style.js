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
            $(".imageClick").unbind("click", flippingCard);// onClick bloqué pour éviter de retourner plus de deux cartes simultanément
            $(".imageClick").removeClass("pointer");

            setTimeout(() => { // Déclanche la fonction après un certain nombre de milliseconde (déterminé dans les paramètre)
                if (thisNameImg != firstClickImg.name || id == firstClickImg.number) { // Si les fruits sont différents (ou click sur la même carte). Le(s) fruit(s) affiché(s) sont/est remplacé(s) par une carte grise
                    $(this).attr("src", "public/img/screen.png");
                    $("#" + firstClickImg.number).attr("src", "public/img/screen.png");

                    click -= 2;  // Les cartes ont été retournées, la valeur des deux clicks est donc soustraite au compteur

                } else {
                    // Bloque les clicks sur les images découvertes et validées
                    $(this).removeClass("imageClick");
                    $("#" + firstClickImg.number).removeClass("imageClick");

                    // Si le nombre de click est égale au nombre de fruit total, la partie est terminée
                    if (click == aNumber) {
                        alert("Vous avez gagnééééééé !")
                        window.location.href = "index.php?action=addGame&pseudo=" + $("#pseudo").html() + "&time=" + $("#chrono").html();
                    }
                    ;
                }

                $(".imageClick").bind("click", flippingCard);//Le onCLick est débloqué pour continuer la partie
                $(".imageClick").addClass("pointer");
            }, 500);
        }
    }

    // Déclaration du onClick sur la fonction
    $(".imageClick").bind("click", flippingCard);

}

function barProgressMove() {
    var width = 0;
    var chrono = 0; // Chronomètre de la partie en seconde (utilisé pour la sauvegarde en bdd)
    var gameTime = 0; // Chronomètre de la partie affiché durant la partie
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
            width += 0.055;
            $("#myBar").width(width + "%");
            $("#myBar").html(parseInt(width) + "%");

            chrono += 0.1; // Chronomètre en seconde

            // Chronomètre affiché à l'écran
            mill++;
            if (mill >= 10) {
                mill = 0;
                sec++;
                if (sec >= 60) {
                    sec = 0;
                    min++;
                }
            }

            sec < 10 ? stringSec = "0" + sec : stringSec = +sec; // ajoût d'un 0 si la valeur de sec est entre 0 et 10

            gameTime = min + '"' + stringSec;

            $("#gameTime").html(gameTime); // Insertion de la valeur dans la div
            $("#chrono").html(parseInt(chrono)); // Insertion de la valeur dans la div
        }
    }
}