<?php

namespace Controller;


class HomeController {

    //Page d'Accueil, le controller ne traite pas de données, il renvoit uniquement le fichier view contenant le code HTML de cette page
    public function index()
    {
        require('view/indexView.php');
    }


}