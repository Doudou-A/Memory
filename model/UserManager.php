<?php

namespace Model;

require_once('Config.php');
use DbConfig;
use \PDO;
require('User.php');


class UserManager
{
	private $_db;

	public function __construct()
  	{
    	$this->setDb(DbConfig::dbConnect());
 	}

 	// Ajouter un Utilisateur
	public function add(User $user)
	{
	    // Requête SQL INSERT pour ajouter des données en base
		$query = $this->_db->prepare('INSERT INTO user(name, idGame) VALUES(:name, :idGame)');

        $query->bindValue(':name', $user->name(), PDO::PARAM_STR);
        $query->bindValue(':idGame', $user->idGame(), PDO::PARAM_INT);

		$query->execute();
	}

	// Récupérer un utilisateur à partir de l'id d'un objet Game
    public function getByGame($idGame)
    {
        // Requête SQL SELECT pour récupérer des données de la base
        $idGame = (int) $idGame;
        $query = $this->_db->prepare('SELECT * FROM User WHERE idGame = :idGame');
        $query->bindValue(':idGame', $idGame, PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        // La fonction retourne un objet User dont les attributs possèdent les données récupérées dans la base de donnée
        return new User($data);
    }

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}
}