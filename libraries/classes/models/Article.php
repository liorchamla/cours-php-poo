<?php

/**
 * DANS CE FICHIER ON DEFINIT UNE CLASSE QUI AURA POUR BUT DE GERER LES DONNEES DES ARTICLES
 * 
 * On appelle souvent cela un Model (une 3 composantes de l'artchitecture MVC)
 */

require_once('libraries/database.php');


/**
 * Classe qui gère les données des articles
 */
class Article
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPdo();
    }

    /**
     * Retourne un article dans la base de données grâce à son id
     *
     * @param integer $id
     *
     * @return array|bool retourne un tableau si on trouve l'article, false si on ne trouve rien
     */
    public function find(int $id): array
    {
        // 2. On prépare une requête
        $query = $this->pdo->prepare("SELECT * FROM articles WHERE id = :article_id");

        // 3. On exécute la requête en précisant le paramètre :article_id 
        $query->execute(['article_id' => $id]);

        // 4. On fouille le résultat pour en extraire les données réelles de l'article
        $article = $query->fetch();

        // 5. On retourne l'article retrouvé
        return $article;
    }

    /**
     * Retourne la liste des articles classés par date
     *
     * @return array
     */
    public function findAll(): array
    {
        // 2. Récupération des articles
        $resultats = $this->pdo->query('SELECT * FROM articles ORDER BY created_at DESC');
        $articles = $resultats->fetchAll();

        // 3. On retourne les articles
        return $articles;
    }

    /**
     * Supprime un article dans la base de données
     *
     * @param integer $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        // 2. On supprime l'article
        $query = $this->pdo->prepare('DELETE FROM articles WHERE id = :id');
        $query->execute(['id' => $id]);
    }
}
