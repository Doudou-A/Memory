<?php

require 'controller/GameController.php';
require 'controller/HomeController.php';

use Controller\{HomeController, GameController};

//Routeur
try {
    // Instanciation des controller
    $controllerFirst = new HomeController;
    $controllerSecond = new GameController;

    // Recherche de lafonction dans les controller à partir du paramètre 'action' transmis par l'url
    if (!empty($_GET['action'])) {
        $action = $_GET['action'];
        if (method_exists($controllerFirst, $action)) {
            $controllerFirst->$action();
        } elseif (method_exists($controllerSecond, $action)) {
            $controllerSecond->$action();
        }
    } else {
        $controllerFirst->index();
    }
} catch (Exeption $e) {
    die('Erreur : '.$e->getMessage());
}

