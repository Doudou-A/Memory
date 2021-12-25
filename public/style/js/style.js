function onClickManage(json,aNumber) {
        //Compteur de click
        var click = 0;

        // Déclaration de l'objet. Il contiendra les données du premier fruit affiché afin de les comparer aux données du deuxième fruit.
        let firstClickImg;

        // Récupération de l'objet (contenant tous les fruits) en faisant un parse sur le Json
        let obj = jQuery.parseJSON(json);

        // Fonction qui gère l'affichage des cartes
        var flippingCard = function () {
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
                $(".image").unbind("click", flippingCard);
                $(".image").removeClass("pointer");

                setTimeout(() => { // la fonction sera déclanché après un temps déterminé dans les paramètres de la fonction
                    if (thisNameImg != firstClickImg.name) { // Si les fruits sont différents. Les deux fruits affichés sont remplacés par une carte grise

                        $(this).attr("src", "public/img/screen.png");
                        $("#" + firstClickImg.number).attr("src", "public/img/screen.png");

                        // Les cartes ont été retourné, la valeur des deux clicks est donc soustraite au compteur
                        click -= 2;
                    } else {
                        click == aNumber ? alert("Vous avez gagnééééééé !"): null;
                    }

                    //Le onCLick est débloqué pour continuer la partie
                    $(".image").bind("click", flippingCard);
                    $(".image").addClass("pointer");
                }, 1000);
            }
        }

        // Déclaration du onClick sur la fonction
        $(".image").bind("click", flippingCard);

}

var i = 0;
function barProgressMove() {
    if (i == 0) {
        i = 1;
        var width = 0;
        var id = setInterval(frame, 100);
        function frame() {
            if (width >= 100) {
                clearInterval(id);
                alert("Vous avez perdu !!!!!!");
                location.reload();
            } else {
                width += 0.02;
                $("#myBar").width(width + "%");
            }
        }
    }
}