<?php

/**
 * CE FICHIER DOIT ENREGISTRER UN NOUVEAU COMMENTAIRE EST REDIRIGER SUR L'ARTICLE !
 * 
 * On doit d'abord vérifier que toutes les informations ont été entrées dans le formulaire
 * Si ce n'est pas le cas : un message d'erreur
 * Sinon, on va sauver les informations
 * 
 * Pour sauvegarder les informations, ce serait bien qu'on soit sur que l'article qu'on essaye de commenter existe
 * Il faudra donc faire une première requête pour s'assurer que l'article existe
 * Ensuite on pourra intégrer le commentaire
 * 
 * Et enfin on pourra rediriger l'utilisateur vers l'article en question
 */

require_once('libraries/utils.php');
require_once('libraries/classes/models/Comment.php');
require_once('libraries/classes/models/Article.php');

$articleModel = new Article();
$commentModel = new Comment();

/**
 * 1. On vérifie que les données ont bien été envoyées en POST
 * D'abord, on récupère les informations à partir du POST
 * Ensuite, on vérifie qu'elles ne sont pas nulles
 */
// On commence par l'author
$author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS);

// Ensuite le contenu
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

// Enfin l'id de l'article
$article_id = filter_input(INPUT_POST, 'article_id', FILTER_VALIDATE_INT);

// Vérification finale des infos envoyées dans le formulaire (donc dans le POST)
// Si il n'y a pas d'auteur OU qu'il n'y a pas de contenu OU qu'il n'y a pas d'identifiant d'article
if (!$author || !$article_id || !$content) {
    die("Votre formulaire a été mal rempli !");
}

/**
 * 2. Vérification que l'id de l'article pointe bien vers un article qui existe
 * Ca nécessite une connexion à la base de données puis une requête qui va aller chercher l'article en question
 * Si rien ne revient, la personne se fout de nous.
 * 
 * A partir de maintenant, fini les répétitions de connexion à la base !
 * On utilise simplement notre fonction getPdo() !
 * 
 * CE N'EST PLUS NECESSAIRE !
 */
// $pdo = getPdo();

$article = $articleModel->find($article_id);
// Si rien n'est revenu, on fait une erreur
if (!$article) {
    die("Ho ! L'article $article_id n'existe pas boloss !");
}

// 3. Insertion du commentaire
$created_at = date('Y-m-d H:i:s');
$commentModel->insert(compact('author', 'content', 'article_id', 'created_at'));

// 4. Redirection vers l'article en question :
redirect('article.php?id=' . $article_id);
