<?php
require('extrait_code/connexion.php'); // Connexion à la base
// Les valeurs envoyées par le formulaire
$identifiant = $_POST['identifiant'];
$mdp = $_POST['mdp'];
// La requête sélectionne les informations de l'utilisateur grâce à ses identifiants
$requete = $sql->query("SELECT identifiant,mdp,statut FROM utilisateurs WHERE identifiant='".$identifiant."' AND mdp='".$mdp."'");

while ($donnees = $requete->fetch()) {
    if ($donnees['statut'] == "utilisateur") { // Si l'utilisateur a le statut utilisateur
        header('Location: user/informations_user.php'); // Il est dirigé sur les formulaires
        setcookie('identifiant', $identifiant); // Le cookie identifiant est crée
        exit(); // Termine le script
    } else if ($donnees['statut'] == "administrateur") {
        header('Location: admin/informations_admin.php'); // Il est dirigé sur l'interface administrateur
        exit(); // Termine le script
    }
}
// Si l'utilisateur n'est pas dirigé, c'est qu'il n'existe pas dans la base de données
// ou qu'il y a eu une erreur
setcookie('erreur', true); // Alors le cookie erreur est crée
header('Location: index.php'); // Redirection vers le formulaire de connexion
?>