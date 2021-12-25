<?php

class GameController
{

    //Page du plateau de jeu, la fonction retourne un tableau contenant le nom des images
    public function game()
    {
        // Récupération du pseudo insérer dans le formulaire de la page d'accueil
        $pseudo = $_POST['pseudo'];

        //Déclaration du tableau d'image
        $aImage = [];

        //Ouverture du dossier contenant le nom des images
        $dossier = opendir('public/img');

        while ($fichier = readdir($dossier))//On une boucle avec While, et avec la fonction readdir on lis ce que contient la variable 'dossier'
        {
            if ($fichier != '.' && $fichier != '..' && $fichier != "screen.png") { //Dans le dossier /img se trouve des fichiers qui ne sont pas des fruits
                for ($i = 0; $i <= 1 ; $i++) { // On boucle afin d'ajouter le même fichier 2 fois dans le tableau
                    $aImage[] = $fichier;
                }
            }
            $cpt++;
        }
        //Fermeture du dossier
        closedir($dossier);

        // Nombre de fruit dans le tableau.
        $aNumber = count($aImage);

        // Mélange les éléments du tableau pour avoir un aloéatoire des fruits à chaque jeu
        shuffle($aImage);

        // Génération d'un JSON afin d'avoir un objet en JS dont les données sont facilement utilisable
        $myJson = json_encode($aImage);

        require('view/game.php');
    }


}