<?php

require('vendor/autoload.php');

$pdo = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$articleQuery = $pdo->prepare("INSERT INTO articles SET title = :title, slug = :slug, created_at = :created_at, introduction = :introduction, content = :content");
$commentQuery = $pdo->prepare("INSERT INTO comments SET article_id = :article_id, author = :author, created_at = :created_at, content = :content");

$pdo->query('DELETE FROM articles; DELETE FROM comments;');

$faker = Faker\Factory::create('fr_FR');

for ($a = 0; $a < 20; $a++) {
    $title = $faker->catchPhrase;
    $slug = $faker->slug;
    $created_at = $faker->dateTimeBetween('-6 months')->format('Y-m-d H:i:s');
    $introduction = $faker->paragraph();
    $content = "<p>" . implode("</p><p>", $faker->paragraphs(5)) . "</p>";
    $articleQuery->execute(compact('title', 'slug', 'created_at', 'introduction', 'content'));

    $article_id = $pdo->lastInsertId();

    $days = "-" . (new DateTime())->diff(new DateTime($created_at))->days . " days";

    $commentsCount = mt_rand(2, 8);
    for ($c = 0; $c < $commentsCount; $c++) {
        $created_at = $faker->dateTimeBetween($days)->format('Y-m-d H:i:s');
        $content = "<p>" . implode("</p><p>", $faker->paragraphs(5)) . "</p>";
        $author = $faker->userName;

        $commentQuery->execute(compact('created_at', 'content', 'author', 'article_id'));
    }
}
