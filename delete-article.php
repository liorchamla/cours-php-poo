<?php

/**
 * DANS CE FICHIER, ON CHERCHE A SUPPRIMER L'ARTICLE DONT L'ID EST PASSE EN GET
 * 
 * Il va donc falloir bien s'assurer qu'un paramètre "id" est bien passé en GET, puis que cet article existe bel et bien
 * Ensuite, on va pouvoir effectivement supprimer l'article et rediriger vers la page d'accueil
 */
require_once('libraries/utils.php');
require_once('libraries/database.php');

/**
 * 1. On vérifie que le GET possède bien un paramètre "id" (delete.php?id=202) et que c'est bien un nombre
 */
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die("Ho ?! Tu n'as pas précisé l'id de l'article !");
}

/**
 * 2. Connexion à la base de données avec PDO
 * A partir de maintenant, fini les répétitions de connexion à la base !
 * On utilise simplement notre fonction getPdo() !
 * 
 * CE N'EST PLUS NECESSAIRE
 */
// $pdo = getPdo();

/**
 * 3. Vérification que l'article existe bel et bien
 */
$article = findArticle($id);
if (!$article) {
    die("L'article $id n'existe pas, vous ne pouvez donc pas le supprimer !");
}

/**
 * 4. Réelle suppression de l'article
 */
deleteArticle($id);

/**
 * 5. Redirection vers la page d'accueil
 */
redirect("index.php");
