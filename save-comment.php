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
require_once('libraries/autoload.php');
$controller = new Controllers\Comment();
$controller->save();
