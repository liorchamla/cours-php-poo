<?php

class Database
{

    /**
     * Retourne une instance de PDO
     * Attention, on précise ici deux options :
     * - Le mode d'erreur : le mode exception permet à PDO de nous prévenir violament quand on fait une connerie ;-)
     * - Le mode d'exploitation : FETCH_ASSOC veut dire qu'on exploitera les données sous la forme de tableaux associatifs
     *
     * @param integer $errorMode Une constante de PDO pour le mode d'erreur (par défaut ERRMODE_EXCEPTION)
     * @param integer $fetchMode Une constante de PDO pour le mode d'exploitation (par défaut FETCH_ASSOC)
     * 
     * Exemple : $obj = getPdo(PDO::ERRMODE_SILENT, PDO::FETCH_BOTH);
     * Exemple 2 : $obj = getPdo();
     * 
     * @return PDO
     */
    public static function getPdo(int $errorMode =  PDO::ERRMODE_EXCEPTION, int $fetchMode = PDO::FETCH_ASSOC): PDO
    {
        return new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', [
            PDO::ATTR_ERRMODE => $errorMode,
            PDO::ATTR_DEFAULT_FETCH_MODE => $fetchMode
        ]);
    }
}
