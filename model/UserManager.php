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

 	//Ajouter un Utilisateur
	public function add(User $user)
	{
		$query = $this->_db->prepare('INSERT INTO user(name, idGame) VALUES(:name, :idGame)');

        $query->bindValue(':name', $user->name(), PDO::PARAM_STR);
        $query->bindValue(':idGame', $user->idGame(), PDO::PARAM_INT);

		$query->execute();
	}

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}
}