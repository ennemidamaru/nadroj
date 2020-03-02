<?php
//on inclue un fichier contenant les informations de connexion à la base de données
include ("connect.php");

//on vérifie que le visiteur a correctement saisi puis envoyé le formulaire
if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pwd']) && !empty($_POST['pwd']))) {
        
        //on se connecte à la bdd
        $connexion = mysql_connect(SERVEUR, LOGIN, MDP);
        if (!$connexion) { echo "La connexion au serveur mysql a échoué"; exit;}
        mysql_select_db(BDD); print "La connexion à la base de données a réussi"; echo "<br />";

        //on parcourt la bdd pour chercher l'existence du login et du mot de passe saisis par le membre et on range le résultat dans le tableau $data
        $sql = 'SELECT COUNT(*) FROM utilisateurs WHERE username="'.mysql_escape_string($_POST['login']).'"
        AND md5="'.mysql_escape_string(md5($_POST['pwd'])).'"';
        $req = mysql_query(($sql)) or die('Erreur MYSQL ! <br />'.$sql '<br />'.mysql_error());
        $data = mysql_fetch_array($req);
        mysql_free_result($req);
        mysql_close();

        //si on obtient une réponse, alors l'utilisateur est un membre
        //on ouvre une session pour cet utilisateur et on le connecte à l'espace membre
        if ($data[0] == 1){
        	session_start();
        	$_SESSION['login'] = $_POST['login'];
        	header('Location: espace-membre.php');
        	exit();}

        //si le visiteur a saisi un mauvais login et/ou mot de passe, on ne trouve aucune réponse
        	elseif ($data[0] == 0){
        		$erreur ='Login ou mot de passe non reconnu !'; echo $erreur;
        		echo "<br /><a href=\"accueil.php\">Accueil</a>"; exit();}

        		//sinon, il existe un problème dans la base de données
        		else {
        			$erreur = 'Plusieurs membres ont les mêmes login et/ou mot de passe !'; echo $erreur;
        			echo "<br /><a href=\"accueil.php\">Accueil</a>"; exit();}}
        			else {
        				$erreur = 'Erreur de saisie ! <br /> Au moins un des champs est vide !'; echo $erreur;
        				echo "<br /><a href=\"accueil.php\">Accueil</a>"; exit();}}
?>
