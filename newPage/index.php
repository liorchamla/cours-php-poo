<?php
    if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
    	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {

    	$base = mysql_connect ('serveur', 'login', 'password');
    	mysql_select_db ('nom_base', $base);

    	$sql = 'SELECT id FROM membre WHERE login="'.mysql_escape_string($_POST['login']).'" AND pass_md5="'.md5(mysql_escape_string($_POST['pass'])).'"';
    	$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
    	$nb = mysql_num_rows($req);

    	if ($nb == 1) {
    		$data = mysql_fetch_array($req);

    		session_start();
    		$_SESSION['login'] = $_POST['login'];
    		// on enregistre en plus l'id du membre dans une variable de session
    		$_SESSION['id'] = $data['id'];

    		mysql_free_result($req);
    		mysql_close();

    		header('Location: membre.php');
    		exit();
    	}
    	elseif ($nb == 0) {
    		$erreur = 'Compte non reconnu.';
    	}
    	else {
    		$erreur = 'Probème dans la base de données : plusieurs membres ont les mêmes identifiants de connexion.';
    	}
    	mysql_free_result($req);
    	mysql_close();
    	}
    	else {
    	$erreur = 'Au moins un des champs est vide.';
    	}
    }
    ?>
    <html>
    <head>
    <title>Accueil</title>
    </head>

    <body>
    Connexion à l'espace membre :<br />
    <form action="index.php" method="post">
    Login : <input type="text" name="login" value="<?php if (isset($_POST['login'])) echo stripslashes(htmlentities(trim($_POST['login']))); ?>"><br />
    Mot de passe : <input type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo stripslashes(htmlentities(trim($_POST['pass']))); ?>"><br />
    <input type="submit" name="connexion" value="Connexion">
    </form>
    <a href="inscription.php">Vous inscrire</a>
    <?php
    if (isset($erreur)) echo '<br /><br />',$erreur;
    ?>
    </body>
    </html>