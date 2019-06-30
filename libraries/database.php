<?php

/**
 * DANS CE FICHIER, ON POSE TOUTES NOS FONCTIONS LIEES A LA BASE DE DONNEES !
 */

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
function getPdo(int $errorMode =  PDO::ERRMODE_EXCEPTION, int $fetchMode = PDO::FETCH_ASSOC): PDO
{
    return new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', [
        PDO::ATTR_ERRMODE => $errorMode,
        PDO::ATTR_DEFAULT_FETCH_MODE => $fetchMode
    ]);
}

/**
 * Retourne un article dans la base de données grâce à son id
 *
 * @param integer $id
 *
 * @return array|bool retourne un tableau si on trouve l'article, false si on ne trouve rien
 */
function findArticle(int $id): array
{
    // 1. On récupère une connexion
    $pdo = getPdo();

    // 2. On prépare une requête
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :article_id");

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
function findAllArticles(): array
{
    // 1. Récupération de la connexion
    $pdo = getPdo();

    // 2. Récupération des articles
    $resultats = $pdo->query('SELECT * FROM articles ORDER BY created_at DESC');
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
function deleteArticle(int $id): void
{
    // 1. On demande la connexion
    $pdo = getPdo();

    // 2. On supprime l'article
    $query = $pdo->prepare('DELETE FROM articles WHERE id = :id');
    $query->execute(['id' => $id]);
}

/**
 * Retourne la liste des commentaires pour un article donné
 *
 * @param integer $article_id
 *
 * @return array
 */
function findAllComments(int $article_id): array
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
function findComment(int $id): array
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
function deleteComment(int $id): void
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
function insertComment(string $author, string $content, int $article_id): void
{
    // 1. On demande une connexion
    $pdo = getPdo();

    // 2. On exécute la requête
    $query = $pdo->prepare('INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()');
    $query->execute(compact('author', 'content', 'article_id'));
}
