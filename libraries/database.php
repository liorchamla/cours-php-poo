<?php

/***
 * Retourne une connexion à la BDD
 * 
 * @return PDO
 */
function getPdo(): PDO
{
    $pdo = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    return $pdo;
}

/***
 * Retourne la liste des articles classés par date de création
 * 
 * @return array
 */
function findAllArticles() : array
{
    $pdo = getPdo();
    $resultats = $pdo->query('SELECT * FROM articles ORDER BY created_at DESC');
    $articles = $resultats->fetchAll();
    
    return $articles;
}

/***
 * Retourne un seul article
 * 
 * @return
 */
function findArticle(int $id)
{
    $pdo = getPdo();
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :article_id");
    $query->execute(['article_id' => $id]);
    $article = $query->fetch();
    
    return $article;
}

/***
 * Retourne tous les commentaires
 * 
 * @return array
 */
function findAllComments(int $article_id) : array
{
    $pdo = getPdo();
    $query = $pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id");
    $query->execute(['article_id' => $article_id]);
    $commentaires = $query->fetchAll();
    
    return $commentaires;
}

/***
 * Supprimer un article
 */
function deleteArticle(int $id) : void
{
    $pdo = getPdo();
    $query = $pdo->prepare('DELETE FROM articles WHERE id = :id');
    $query->execute(['id' => $id]);
}

/***
 * Retourne un seul commentaire
 * 
 * @return 
 */
function findComment(int $id)
{
    $pdo = getPdo();
    $query = $pdo->prepare('SELECT * FROM comments WHERE id = :id');
    $query->execute(['id' => $id]);
    $comment = $query->fetch();
    
    return $comment;
}

/***
 * Supprimer un commentaire
 */
function deleteComment(int $id) : void
{
    $pdo = getPdo();
    $query = $pdo->prepare('DELETE FROM comments WHERE id = :id');
    $query->execute(['id' => $id]);
}

/***
 * Ajouter un commantaire
 * 
 * @return
 */
function insertComment(string $author, string $content, int $article_id) : void
{
    $pdo = getPdo();
    $query = $pdo->prepare('INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()');
    $query->execute(compact('author', 'content', 'article_id'));
}


