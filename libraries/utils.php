<?php

/**
 * Affiche la vue demandée dans $path en injectant les variables contenues dans $variables
 *
 * @param string $path
 * @param array $variables
 *
 * @return void
 */
function render(string $path, array $variables = []): void
{
    /**
     * Astuce extraordinaire : la fonction extract() !
     * Elle permet de créer des variables à partir d'un tableau associatif !
     * Exemple : 
     * Dire : extract(['id' => 2, 'title' => "Bonjour !"]);
     * Equivaut à dire :
     * $id = 2;
     * $title = "Bonjour !";
     */
    extract($variables);

    ob_start();
    require('templates/' . $path . '.html.php');
    $pageContent = ob_get_clean();

    require('templates/layout.html.php');
}


/**
 * Redirige le visiteur vers $uri
 *
 * @param string $uri
 *
 * @return void
 */
function redirect(string $uri): void
{
    header("Location: $uri");
    exit();
}
