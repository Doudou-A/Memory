<?php

class GameController {

    //Page d'Accueil, le controller ne traite pas de données, il renvoit uniquement le fichier view contenant le code HTML de cette page
    public function game()
    {
        $pseudo = $_POST['pseudo'];

        require('view/game.php');
    }


}