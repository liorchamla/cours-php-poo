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

require_once('./libraries/database.php');
require_once('./libraries/utils.php');

/**
 * 1. Récupération du param "id" et vérification de celui-ci
 */
// On part du principe qu'on ne possède pas de param "id"
$article_id = null;

// Mais si il y'en a un et que c'est un nombre entier, alors c'est cool
if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    $article_id = $_GET['id'];
}

// On peut désormais décider : erreur ou pas ?!
if (!$article_id) {
    die("Vous devez préciser un paramètre `id` dans l'URL !");
}

/**
 * 3. Récupération de l'article en question
 * On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur : Ne faites
 * jamais confiance à ce connard d'utilisateur ! :D
 */
$article = findArticle($article_id);

/**
 * 4. Récupération des commentaires de l'article en question
 * Pareil, toujours une requête préparée pour sécuriser la donnée filée par l'utilisateur (cet enfoiré en puissance !)
 */
$commentaires = findAllComments($article_id);

/**
 * 5. On affiche: les variables "$pageTitle" et "$pageContent" sont appelées dans templates/layout.html.php
 */
$pageTitle = $article['title'];

/******************************************** DRY du tableau associatuf: utiliser la fonction php: "compact()"
                              // NB: toutes ces variables créées existent à l'extérieur grâce à la fonction "extract();" utilisée dans "utils.php"
render('articles/show', [    // variables nécessaires pour l'affichage demandées par le tableau associatif de la "function render" dans "utils;php"
    'pageTitle'     => $pageTitle, 
    'article'       => $article, 
    'commentaires'  => $commentaires, 
    'article_id'    => $article_id    // + l'id de l'article (dans "show.html.php")
]);
*******************************/

render('articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));  // remplace le tableau associatif ci-dessus


