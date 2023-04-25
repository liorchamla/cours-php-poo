<?php

namespace Controllers;

class Article extends Controller
{
    protected $modelName = \Models\Article::class;  // ou     protected $modelName = "\Models\Article";


    public function index()
    {
        /**
         * 2. Récupération des articles
         */
        $articles = $this->model->findAll("created_at DESC");

        /**
         * 3. Affichage: les variables "$pageTitle" et "$pageContent" sont appelées dans templates/layout.html.php
         */
        $pageTitle = "Accueil";

        \Renderer::render('articles/index', compact('pageTitle', 'articles'));
    }

    public function show()
    {
        $CommentModel = new \Models\Comment();

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
        $article = $this->model->find($article_id);

        /**
         * 4. Récupération des commentaires de l'article en question
         * Pareil, toujours une requête préparée pour sécuriser la donnée filée par l'utilisateur (cet enfoiré en puissance !)
         */
        $commentaires = $CommentModel->findAllWithArticle($article_id);

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

        \Renderer::render('articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));  // remplace le tableau associatif ci-dessus


    }

    public function delete()
    {
        /**
         * 1. On vérifie que le GET possède bien un paramètre "id" (delete.php?id=202) et que c'est bien un nombre
         */
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ?! Tu n'as pas précisé l'id de l'article !");
        }

        $id = $_GET['id'];

        /**
         * 3. Vérification que l'article existe bel et bien
         */
        $article = $this->model->find($id);
        if (!$article) {
            die("L'article $id n'existe pas, vous ne pouvez donc pas le supprimer !");
        }

        $this->model->delete($id);

        /**
         * 5. Redirection vers la page d'accueil
         */
        \Http::redirect("index.php");
    }
}

?>