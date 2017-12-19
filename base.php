<?php
try {
	$dbh = new PDO ("mysql:host=localhost;dbname=pictionnary", "test", "test");
	$dbh->exec('SET NAMES utf8');
}
catch (Exception $e) {
	die ("Erreur: Connexion à la base impossible");
}
?>
