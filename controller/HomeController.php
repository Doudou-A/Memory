<?php

namespace Controller;

require_once 'model/GameManager.php';
require_once 'model/UserManager.php';

//Namespace
use Model\{GameManager, UserManager};

class HomeController
{

    //Page d'Accueil
    public function index()
    {
        $managerGame = new GameManager();
        $managerUser = new UserManager();

        $allScores = $managerGame->getAll(); // Récupération de l'attribut gameTime des parties jouées
        if ($allScores) {
            sort($allScores); // Trie du tableau

            $bestScore = [];
            for ($i = 0; $i < 5; $i++) {  // On souhaite uniquement les 5 meilleurs scores
                if($i > count($allScores) - 1) continue; // Si le nombre total de partie est inférieur à 5
                $game = $managerGame->getByTime($allScores[$i]["gameTime"]); // Récupérer le jeu dans la bdd à partir du temps
                $user = $managerUser->getByGame($game->id()); // Récupérer le joueur à partir de l'objet Game

                // Modification du format de l'affichage pour le temps
                $aTime = explode(".", $game->gameTime() / 60);
                $sec = $game->gameTime() % 60;
                $time = "0" . $aTime[0] . '"' . ($sec < 10 ? "0".$sec : $sec );

                // Tableau contenant les données (joueur, temps) des 5 meilleurs jeux
                $bestScore[] = [
                    "pseudo" => $user->name(),
                    "time" => $time,
                ];
            }
        }

        require('view/indexView.php'); // Appel du template
    }


}