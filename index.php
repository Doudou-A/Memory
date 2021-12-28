<?php

require 'controller/GameController.php';
require 'controller/HomeController.php';

//Namespace
use Controller\{HomeController, GameController};

//Routeur
try {
    // Instanciation des Controller
    $controllerFirst = new HomeController;
    $controllerSecond = new GameController;

    // Recherche de la fonction dans les controller à partir du paramètre 'action' transmis par l'url
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

