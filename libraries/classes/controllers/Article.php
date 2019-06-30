<?php

namespace Controllers;

// On aura besoin de la fonction render() qui se trouve dans utils.php
require_once('libraries/utils.php');
// On aura besoin de la classe Article pour récupérer les données
require_once('libraries/classes/models/Article.php');
require_once('libraries/classes/models/Comment.php');

class Article
{
    public function index()
    {
        $model = new \Models\Article();

        /**
         * 1. Récupération des articles
         */
        $articles = $model->findAll('created_at DESC');

        /**
         * 2. Affichage
         */
        $pageTitle = "Accueil";
        render("articles/index", compact('articles', 'pageTitle'));
    }

    public function show()
    {
        // On aura besoin du model Article et du model Comment
        $articleModel = new \Models\Article();
        $commentModel = new \Models\Comment();

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

        render("articles/show", compact('pageTitle', 'article', 'commentaires', 'article_id'));
    }

    public function delete()
    {
        $model = new \Models\Article();

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
        $article = $model->find($id);
        if (!$article) {
            die("L'article $id n'existe pas, vous ne pouvez donc pas le supprimer !");
        }

        /**
         * 4. Réelle suppression de l'article
         */
        $model->delete($id);

        /**
         * 5. Redirection vers la page d'accueil
         */
        redirect("index.php");
    }
}
