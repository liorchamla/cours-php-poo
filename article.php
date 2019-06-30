<?php

/**
 * CE FICHIER DOIT AFFICHER UN ARTICLE ET SES COMMENTAIRES !
 * 
 * On doit d'abord récupérer le paramètre "id" qui sera présent en GET et vérifier son existence
 * Si on n'a pas de param "id", alors on affiche un message d'erreur !
 * 
 * Sinon, on va se connecter à la base de données, récupérer les commentaires du plus ancien au plus récent (SELECT * FROM comments WHERE article_id = ?)
 * 
 * On va ensuite afficher l'article puis ses commentaires
 */

// On aura besoin de la fonction render() qui se trouve dans le fichier libraries/utils.php
require_once('libraries/utils.php');
// On aura besoin du model Article et du model Comment
require_once('libraries/classes/models/Article.php');
require_once('libraries/classes/models/Comment.php');
$articleModel = new Article();
$commentModel = new Comment();


/**
 * 1. Récupération du param "id" et vérification de celui-ci
 */
// On part du principe qu'on ne possède pas de param "id"
$article_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// On peut désormais décider : erreur ou pas ?!
if (!$article_id) {
    die("Vous devez préciser un paramètre `id` dans l'URL !");
}

/**
 * 2. Connexion à la base de données avec PDO
 * A partir de maintenant, fini les répétitions de connexion à la base !
 * On utilise simplement notre fonction getPdo() !
 * 
 * CE N'EST PLUS NECESSAIRE !
 */
// $pdo = getPdo();

/**
 * 3. Récupération de l'article en question
 * On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur : Ne faites
 * jamais confiance à ce connard d'utilisateur ! :D
 */
$article = $articleModel->find($article_id);

/**
 * 4. Récupération des commentaires de l'article en question
 * Pareil, toujours une requête préparée pour sécuriser la donnée filée par l'utilisateur (cet enfoiré en puissance !)
 */
$commentaires = $commentModel->findAllWithArticle($article_id);

/**
 * 5. On affiche 
 */
$pageTitle = $article['title'];

render("articles/show", compact('pageTitle', 'article', 'commentaires'));
