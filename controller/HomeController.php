<?php

namespace Controller;

require_once 'model/GameManager.php';
require_once 'model/UserManager.php';

use Model\{GameManager, UserManager};

class HomeController
{

    //Page d'Accueil, le controller ne traite pas de données, il renvoit uniquement le fichier view contenant le code HTML de cette page
    public function index()
    {
        $managerGame = new GameManager();
        $managerUser = new UserManager();

        $allScores = $managerGame->getBest();

        if ($allScores) {
            sort($allScores);

            $bestScore = [];
            for ($i = 0; $i < 5; $i++) {
                $game = $managerGame->getByTime($allScores[$i]["gameTime"]);
                $user = $managerUser->getByGame($game->id());

                $aTime = explode(".", $game->gameTime() / 60);
                $time = $aTime[0] . ":" . ($game->gameTime() % 60);

                $bestScore[] = [
                    "pseudo" => $user->name(),
                    "time" => $time,
                ];
            }
        }

        echo '<pre>' . var_export($bestScore, true) . '</pre>';
        require('view/indexView.php');
    }


}