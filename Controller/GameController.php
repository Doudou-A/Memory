<?php

class GameController
{

    //Page d'Accueil, le controller ne traite pas de données, il renvoit uniquement le fichier view contenant le code HTML de cette page
    public function game()
    {
        $pseudo = $_POST['pseudo'];

        $aImage = [];
        $aUniqueNumber = [];

        $dossier = opendir('public/img');
        while ($fichier = readdir($dossier))//On une boucle avec While, et avec la fonction readdir on lis ce que contient la variable 'dossier' ( false !== vérifie que la lecture du dossier n'a pas retourné d'erreur.)
        {
            if ($fichier != '.' && $fichier != '..') {
                while (in_array($firstNumber = mt_rand(0, 35), $aUniqueNumber)) ;
                $aImage[$firstNumber] = $fichier;
                $aUniqueNumber[] = $firstNumber;

                while (in_array($secondNumber = mt_rand(0, 35), $aUniqueNumber)) ;
                $aImage[$secondNumber] = $fichier;
                $aUniqueNumber[] = $secondNumber;
            }
        }
        closedir($dossier);

        shuffle($aImage);
        require('view/game.php');
    }


}