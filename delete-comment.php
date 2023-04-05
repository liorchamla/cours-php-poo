<?php

/**
 * DANS CE FICHIER ON CHERCHE A SUPPRIMER LE COMMENTAIRE DONT L'ID EST PASSE EN PARAMETRE GET !
 * 
 * On va donc vérifier que le paramètre "id" est bien présent en GET, qu'il correspond bien à un commentaire existant
 * Puis on le supprimera !
 */

require_once('./libraries/database.php');
require_once('./libraries/utils.php');

/**
 * 1. Récupération du paramètre "id" en GET
 */
if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("Ho ! Fallait préciser le paramètre id en GET !");
}

$id = $_GET['id'];

/**
 * 3. Vérification de l'existence du commentaire
 */
$commentaire = findComment($id);
if(!$commentaire) {
    die("Aucun commentaire n'a l'identifiant $id !");
}

/**
 * 4. Suppression réelle du commentaire
 * On récupère l'identifiant de l'article avant de supprimer le commentaire
 */
$article_id = $commentaire['article_id'];
deleteComment($id);

/**
 * 5. Redirection vers l'article en question
 */

/* remplacer:
header("Location: article.php?id=" . $article_id);
exit();
par: la fonction "redirect();" de "utils.php" */

redirect("article.php?id=" . $article_id);
