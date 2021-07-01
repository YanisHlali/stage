<?php
require('../extrait_code/connexion.php'); // Connexion à la base

$id = $_GET['id'];
// Requête qui supprime les utilisateurs
$sql->query("DELETE FROM utilisateurs WHERE id=$id");
$sql->query("DELETE FROM identite WHERE id_identite=$id");
$sql->query("DELETE FROM experience WHERE id_experience=$id");
$sql->query("DELETE FROM formation WHERE id_formation=$id");

header('Location: informations_admin.php'); // Redirection
?>