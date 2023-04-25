<?php

namespace Controllers;

class Comment extends Controller
{

    protected $modelName = \Models\Comment::class;  // ou     protected $modelName = "\Models\Comment";

    public function insert()
    {

        $articleModel = new \Models\Article();

        /**
         * 1. On vérifie que les données ont bien été envoyées en POST
         * D'abord, on récupère les informations à partir du POST
         * Ensuite, on vérifie qu'elles ne sont pas nulles
         */
        // On commence par l'author
        $author = null;
        if (!empty($_POST['author'])) {
            $author = $_POST['author'];
        }

        // Ensuite le contenu
        $content = null;
        if (!empty($_POST['content'])) {
            // On fait quand même gaffe à ce que le gars n'essaye pas des balises cheloues dans son commentaire
            $content = htmlspecialchars($_POST['content']);
        }

        // Enfin l'id de l'article
        $article_id = null;
        if (!empty($_POST['article_id']) && ctype_digit($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
        }

        // Vérification finale des infos envoyées dans le formulaire (donc dans le POST)
        // Si il n'y a pas d'auteur OU qu'il n'y a pas de contenu OU qu'il n'y a pas d'identifiant d'article
        if (!$author || !$article_id || !$content) {
            die("Votre formulaire a été mal rempli !");
        }

        $article = $articleModel->find($article_id);

        if (!$article) {
            die("Ho ! L'article $article_id n'existe pas boloss !");
        }

        // 3. Insertion du commentaire
        $this->model->insert($author, $content, $article_id);

        // 4. Redirection vers l'article en question :

        \Http::redirect("article.php?controller=article&task=show&id=" . $article_id);
    }

    public function delete()
    {

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
        $commentaire = $this->model->find($id);
        if (!$commentaire) {
            die("Aucun commentaire n'a l'identifiant $id !");
        }

        /**
         * 4. Suppression réelle du commentaire
         * On récupère l'identifiant de l'article avant de supprimer le commentaire
         */
        $article_id = $commentaire['article_id'];
        $this->model->delete($id);

        /**
         * 5. Redirection vers l'article en question
         */

        /* remplacer:
        header("Location: article.php?id=" . $article_id);
        exit();
        par: la fonction "redirect();" de "utils.php" */

        \Http::redirect("index.php?controller=article&task=show&id=" . $article_id);
    }
}

?>