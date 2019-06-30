<?php

/**
 * DANS CE FICHIER ON DEFINIT UNE CLASSE QUI AURA POUR BUT DE GERER LES DONNEES DES COMMENTAIRES
 * 
 * On appelle souvent cela un Model (une 3 composantes de l'artchitecture MVC)
 */

require_once('libraries/database.php');

/**
 * Classe qui gère les données des commentaires
 */
class Comment
{
    /**
     * Retourne la liste des commentaires pour un article donné
     *
     * @param integer $article_id
     *
     * @return array
     */
    public function findAllWithArticle(int $article_id): array
    {
        // 1. On récupère une connexion
        $pdo = getPdo();

        // 2. On récupère les commentaires
        $query = $pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id");
        $query->execute(['article_id' => $article_id]);
        $commentaires = $query->fetchAll();

        // 3. On retourne les commentaires
        return $commentaires;
    }


    /**
     * Retourne les informations d'un commentaire grâce à son id
     *
     * @param integer $id
     *
     * @return array|bool retourne un tableau avec les données du commentaire, ou false si on ne trouve pas le commentaire
     */
    public function find(int $id): array
    {
        // 1. On demande une connexion
        $pdo = getPdo();

        // 2. On exécute la requête et on récupère le commentaire
        $query = $pdo->prepare('SELECT * FROM comments WHERE id = :id');
        $query->execute(['id' => $id]);
        $comment = $query->fetch();

        // 3. On retourne le commentaire
        return $comment;
    }

    /**
     * Supprime un commentaire grâce à son id
     *
     * @param integer $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        // 1. On demande une connexion
        $pdo = getPdo();

        // 2. On exécute la suppression
        $query = $pdo->prepare('DELETE FROM comments WHERE id = :id');
        $query->execute(['id' => $id]);
    }

    /**
     * Insère un nouveau commentaire dans la base de données
     *
     * @param string $author
     * @param string $content
     * @param integer $article_id
     *
     * @return void
     */
    public function insert(string $author, string $content, int $article_id): void
    {
        // 1. On demande une connexion
        $pdo = getPdo();

        // 2. On exécute la requête
        $query = $pdo->prepare('INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()');
        $query->execute(compact('author', 'content', 'article_id'));
    }
}
