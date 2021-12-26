<?php

namespace Controller;

require_once 'model/GameManager.php';
require_once 'model/UserManager.php';

use Model\{Game, GameManager, User, UserManager};

class GameController
{

    //Page du plateau de jeu, la fonction retourne un tableau contenant le nom des images
    public function displayGame()
    {
        // Récupération du pseudo insérer dans le formulaire de la page d'accueil
        $pseudo = $_POST['pseudo'];

        //Déclaration du tableau d'image
        $aImage = [];

        //Ouverture du dossier contenant le nom des images
        $dossier = opendir('public/img');
        while ($fichier = readdir($dossier))//On une boucle avec While, et avec la fonction readdir on lis ce que contient la variable 'dossier'
        {
            if ($fichier != '.' && $fichier != '..' && $fichier != "screen.png") {
                for ($i = 0; $i <= 1; $i++) { // On boucle afin d'ajouter le même fichier 2 fois dans le tableau
                    $aImage[] = $fichier;
                }
            }
        }
        //Fermeture du dossier
        closedir($dossier);

        // Nombre de fruit dans le tableau.
        $aNumber = count($aImage);

        // Mélange des éléments du tableau pour avoir un emplacement des fruits aléatoire à chaque jeu
        shuffle($aImage);

        // Génération d'un JSON pour l'utilisation du tableau en JS
        $myJson = json_encode($aImage);

        require('view/game.php');
    }

    // Insertion d'une partie terminédans la base de données
    public function addGame()
    {
        $managerGame = new GameManager();
        $managerUser = new UserManager();

        // Création d'un objet Game en instanciant la classe Game
        $game = new Game([
            'gameTime' => $_GET['time'], // $_GET permet de récupérer un paramètre dans url
        ]);

        $idGame = $managerGame->add($game); // Insertion de l'objet en bdd, la fonction retourne l'id assigné à l'objet lors de l'insertion

        // Création d'un objet User en instanciant la classe User
        $user = new User([
            'name' => $_GET['pseudo'],
            'idGame' => $idGame
        ]);
        $managerUser->add($user); // Création d'un nouvel User en base

        header("Location: index.php");
        exit;

    }


}