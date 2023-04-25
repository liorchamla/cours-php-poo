<?php
    session_start();
    // on vérifie toujours qu'il s'agit d'un membre qui est connecté
    if (!isset($_SESSION['login'])) {
    	// si ce n'est pas le cas, on le redirige vers l'accueil
    	header ('Location: index.php');
    	exit();
    }
    ?>

    <html>
    <head>
    <title>Espace membre</title>
    </head>

    <body>
    Bienvenue <?php echo stripslashes(htmlentities(trim($_SESSION['login']))); ?> !<br /><br />
    <?php
    $base = mysql_connect ('serveur', 'login', 'password');
    mysql_select_db ('nom_base', $base);

    // on prépare une requete SQL cherchant tous les titres, les dates ainsi que l'auteur des messages pour le membre connecté
    $sql = 'SELECT titre, date, membre.login as expediteur, messages.id as id_message FROM messages, membre WHERE id_destinataire="'.$_SESSION['id'].'" AND id_expediteur=membre.id ORDER BY date DESC';
    // lancement de la requete SQL
    $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
    $nb = mysql_num_rows($req);

    if ($nb == 0) {
    	echo 'Vous n\'avez aucun message.';
    }
    else {
    	// si on a des messages, on affiche la date, un lien vers la page lire.php ainsi que le titre et l'auteur du message
    	while ($data = mysql_fetch_array($req)) {
    	echo $data['date'] , ' - <a href="lire.php?id_message=' , $data['id_message'] , '">' , stripslashes(htmlentities(trim($data['titre']))) , '</a> [ Message de ' , stripslashes(htmlentities(trim($data['expediteur']))) , ' ]<br />';
    	}
    }
    mysql_free_result($req);
    mysql_close();
    ?>
    <br /><a href="envoyer.php">Envoyer un message</a>
    <br /><br /><a href="deconnexion.php">Déconnexion</a>
    </body>
    </html>