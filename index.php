<?php

//Autoloader
spl_autoload_register(function ($class_name) {
    include 'controller/' . $class_name . '.php';
});

//Routeur
try {
    $controllerFirst = new HomeController;
    $controllerSecond = new GameController;
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

