<?php

Class DbConfig{

    // Connexion à la base de données
	public static function dbConnect()
	{
		return new PDO('mysql:host=localhost;dbname=Memory;charset=utf8', 'root', 'root');
	}
}