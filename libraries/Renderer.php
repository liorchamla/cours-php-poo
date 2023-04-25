<?php

class Renderer
{
    /**
     * Affiche un template HTML en injectant les $variables
     * 
     * @param string $path
     * @param array $variables
     * @return void
     */
    public static function render(string $path, array $variables = [])  /* variables $articles et $commentaires non reconnues à l'extérieur:
        créer un tableau associatif de variable qui par défaut sera un tableau vide,
        à chaque appel de la "function render", donner le fichier à afficher + donner un tableau dans lequel on va identifier les variables
        nécessaires (cf article.php)
        */
    {
        extract($variables);  //fonction "extract();" extrait les données du tableau associatif et en fait de véritables variables

        ob_start();  // tout ce qui va être afficher va aller dans ce tampon: pas encore affiché !!
        require('templates/' . $path . '.html.php');
        $pageContent = ob_get_clean();  // afficher tout ce qui était dans le tampon (ce qui est affiché est dans require('templates/articles/index.html.php');)

        require('templates/layout.html.php');  // afficher la mise en page complétée
    }
}

?>