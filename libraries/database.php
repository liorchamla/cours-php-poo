<?php

class Database{

private static $instance = null;

/***
 * Retourne une connexion à la BDD
 * Pattern du singleton, design pattern ou « patrons de conception »
 * 
 * @return PDO
 */
public static function getPdo(): PDO   //Limiter les connexions à MySQL: à partir du moment où on est connecté, inutile de se reconnecter
{
    if(self::$instance === null)  {//Appeler une propriété static dans une classe
        self::$instance = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}
    return self::$instance;
}
}
?>

