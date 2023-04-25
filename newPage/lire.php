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
    <a href="membre.php">Retour à l'accueil</a><br /><br />
    <?php
    // on teste si notre paramètre existe bien et qu'il n'est pas vide
    if (!isset($_GET['id_message']) || empty($_GET['id_message'])) {
    	echo 'Aucun message reconnu.';
    }
    else {
    	$base = mysql_connect ('serveur', 'login', 'password');
    	mysql_select_db ('nom_base', $base);

    	// on prépare une requete SQL selectionnant la date, le titre et l'expediteur du message que l'on souhaite lire, tout en prenant soin de vérifier que le message appartient bien au membre connecté
    	$sql = 'SELECT titre, date, message, membre.login as expediteur FROM messages, membre WHERE id_destinataire="'.$_SESSION['id'].'" AND id_expediteur=membre.id AND messages.id="'.$_GET['id_message'].'"';
    	// on lance cette requete SQL à MySQL
    	$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
    	$nb = mysql_num_rows($req);

    	if ($nb == 0) {
    	echo 'Aucun message reconnu.';
    	}
    	else {
    	// si le message a été trouvé, on l'affiche
    	$data = mysql_fetch_array($req);
    	echo $data['date'] , ' - ' , stripslashes(htmlentities(trim($data['titre']))) , '</a> [ Message de ' , stripslashes(htmlentities(trim($data['expediteur']))) , ' ]<br /><br />';
    	echo nl2br(stripslashes(htmlentities(trim($data['message']))));

    	// on affiche également un lien permettant de supprimer ce message de la boite de réception
    	echo '<br /><br /><a href="supprimer.php?id_message=' , $_GET['id_message'] , '">Supprimer ce message</a>';
    	}
    	mysql_free_result($req);
    	mysql_close();
    }
    ?>
    <br /><br /><a href="deconnexion.php">Déconnexion</a>
    </body>
    </html>