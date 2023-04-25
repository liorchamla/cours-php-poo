<?php

namespace Models;

abstract class Model{

    protected $pdo;
    protected $table;

    public function __construct()
    {
        $this->pdo = \Database::getPdo();
    } 

/***
 * Retourne un seul article
 * 
 * @return array or false
 */
public function find(int $id)
{
    $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
    $query->execute(['id' => $id]);
    $item = $query->fetch();
    
    return $item;
}

/***
 * Supprimer un commentaire
 */
public function delete(int $id) : void
{
    $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
    $query->execute(['id' => $id]);
}

/***
 * Retourne la liste des articles classés par date de création
 * 
 * @return array
 */
public function findAll(?string $order = "") : array
{
    $sql = "SELECT * FROM {$this->table}";

    if($order){
        $sql .= " ORDER BY " . $order;
    }
    $resultats = $this->pdo->query($sql);
    $articles = $resultats->fetchAll();
    
    return $articles;
}


}
?>