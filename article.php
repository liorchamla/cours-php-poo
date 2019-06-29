<?php

/**
 * CE FICHIER DOIT AFFICHER UN ARTICLE ET SES COMMENTAIRES !
 * 
 * On doit d'abord récupérer le paramètre "id" qui sera présent en GET et vérifier son existence
 * Si on n'a pas de param "id", alors on affiche un message d'erreur !
 * 
 * Sinon, on va se connecter à la base de données, récupérer les commentaires du plus ancien au plus récent (SELECT * FROM comments WHERE article_id = ?)
 * 
 * On va ensuite afficher l'article puis ses commentaires
 */

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
 * 2. Connexion à la base de données avec PDO
 * Attention, on précise ici deux options :
 * - Le mode d'erreur : le mode exception permet à PDO de nous prévenir violament quand on fait une connerie ;-)
 * - Le mode d'exploitation : FETCH_ASSOC veut dire qu'on exploitera les données sous la forme de tableaux associatifs
 * 
 * PS : Vous remarquez que ce sont les mêmes lignes que pour l'index.php ?!
 */
$pdo = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

/**
 * 3. Récupération de l'article en question
 * On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur : Ne faites
 * jamais confiance à ce connard d'utilisateur ! :D
 */
$query = $pdo->prepare("SELECT * FROM articles WHERE id = :article_id");

// On exécute la requête en précisant le paramètre :article_id 
$query->execute(['article_id' => $article_id]);

// On fouille le résultat pour en extraire les données réelles de l'article
$article = $query->fetch();

/**
 * 4. Récupération des commentaires de l'article en question
 * Pareil, toujours une requête préparée pour sécuriser la donnée filée par l'utilisateur (cet enfoiré en puissance !)
 */
$query = $pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id");
$query->execute(['article_id' => $article_id]);
$commentaires = $query->fetchAll();

/**
 * 5. On affiche 
 * PS : Vous remarquez qu'on répète la structure HTML encore une fois ...
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon superbe blog - <?= $article['title'] ?></title>
</head>

<body>
    <h1><?= $article['title'] ?></h1>
    <small>Ecrit le <?= $article['created_at'] ?></small>
    <p><?= $article['introduction'] ?></p>
    <hr>
    <?= $article['content'] ?>

    <?php if (count($commentaires) === 0) : ?>
        <h2>Il n'y a pas encore de commentaires pour cet article ... SOYEZ LE PREMIER ! :D</h2>
    <?php else : ?>
        <h2>Il y a déjà <?= count($commentaires) ?> réactions : </h2>
        <?php foreach ($commentaires as $commentaire) : ?>
            <h3>Commentaire de <?= $commentaire['author'] ?></h3>
            <small>Le <?= $commentaire['created_at'] ?></small>
            <blockquote>
                <em><?= $commentaire['content'] ?></em>
            </blockquote>
            <a href="delete-comment.php?id=<?= $commentaire['id'] ?>" onclick="return window.confirm(`Êtes vous sûr de vouloir supprimer ce commentaire ?!`)">Supprimer</a>
        <?php endforeach ?>
    <?php endif ?>

    <form action="save-comment.php" method="POST">
        <h3>Vous voulez réagir ? N'hésitez pas les bros !</h3>
        <input type="text" name="author" placeholder="Votre pseudo !">
        <textarea name="content" id="" cols="30" rows="10" placeholder="Votre commentaire ..."></textarea>
        <input type="hidden" name="article_id" value="<?= $article_id ?>">
        <button>Commenter !</button>
    </form>
</body>

</html>