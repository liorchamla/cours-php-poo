<?php

/**
 * DANS CE FICHIER ON CHERCHE A SUPPRIMER LE COMMENTAIRE DONT L'ID EST PASSE EN PARAMETRE GET !
 * 
 * On va donc vérifier que le paramètre "id" est bien présent en GET, qu'il correspond bien à un commentaire existant
 * Puis on le supprimera !
 */
require_once('libraries/utils.php');
require_once('libraries/database.php');

/**
 * 1. Récupération du paramètre "id" en GET
 */
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die("Ho ! Fallait préciser le paramètre id en GET !");
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
 * 3. Vérification de l'existence du commentaire
 */
$commentaire = findComment($id);
if (!$commentaire) {
    die("Aucun commentaire n'a l'identifiant $id !");
}

/**
 * 4. Suppression réelle du commentaire
 * On récupère l'identifiant de l'article avant de supprimer le commentaire
 */
deleteComment($id);

/**
 * 5. Redirection vers l'article en question
 */
$article_id = $commentaire['article_id'];
redirect('article.php?id=' . $article_id);
