<?php

session_start();
if (!isset($_SESSION['login'])) {header ('Location: index.php'); exit();}
?>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<title>Espace membre</title>
	</head>
	<body>
		<p><strong>ESPACE MEMBRE</strong><br />
			Bienvenue <?php echo htmlentities(trim($_SESSION['login'])); ?> ! <br />
			<a href="deconnexion.php">Deconexion</a>
		</p>
	</body>
</html>