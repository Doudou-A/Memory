<?php

namespace Model;

require_once('Config.php');
use DbConfig;
use \PDO;
require_once('Game.php');


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

		$query->bindValue(':gameTime', $game->gameTime(), PDO::PARAM_INT);

		$query->execute();

        return $this->_db->lastInsertId();
	}

    public function getBest()
    {
        $query = $this->_db->query('SELECT gameTime FROM Game');
        $data = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $data;
    }

    public function getByTime($time)
    {
        $time = (int) $time;
        $query = $this->_db->prepare('SELECT * FROM Game WHERE gameTime = :time');
        $query->bindValue(':time', $time, PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        return new Game($data);
    }

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}
}