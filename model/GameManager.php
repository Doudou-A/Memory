<?php

namespace Model;

require_once('Config.php');
use DbConfig;
use \PDO;
require('Game.php');


class GameManager
{
	private $_db;

	public function __construct()
  	{
    	$this->setDb(DbConfig::dbConnect());
 	}

 	//Ajouter une partie dans la bdd
	public function add(Game $game)
	{
		$query = $this->_db->prepare('INSERT INTO game(gameTime) VALUES(:gameTime)');

		$query->bindValue(':gameTime', $game->gameTime(), PDO::PARAM_STR);

		$query->execute();

        return $this->_db->lastInsertId();
	}

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}
}