<?php

/**
 * CE FICHIER A POUR BUT D'AFFICHER LA PAGE D'ACCUEIL !
 * 
 * On va donc se connecter à la base de données, récupérer les articles du plus récent au plus ancien (SELECT * FROM articles ORDER BY created_at DESC)
 * puis on va boucler dessus pour afficher chacun d'entre eux
 */

//('./libraries/controllers/Article.php'); ---> remplacer par l'autoload.

require_once('./libraries/autoload.php');

\Application::process();

/*
$controller = new \Controllers\Article();
$controller->index();
*/
?>
