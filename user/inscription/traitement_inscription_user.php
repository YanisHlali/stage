<?php
require('../../extrait_code/connexion.php'); // Connexion à la base
// Les valeurs envoyées par le formulaire
$identifiant = $_POST['identifiant'];
$mdp = $_POST['mdp'];
$statut = 'utilisateur';
// Fonction qui crée un pop-up
function popUp($identifiant,$mdp) {
    echo "<script type='text/javascript'>
    alert('Votre identifiant : ".$identifiant."et votre mot de passe : ".$mdp."');
    </script>";
}
popUp($identifiant, $mdp); // Appelle la fonction pop-up
// Sélectionne toute la base utilisateurs
$requete = $sql->query("SELECT * FROM utilisateurs");

while ($donnees = $requete->fetch()) {
    // Si l'identifiant existe déjà alors le cookie erreur est crée et vaut identifiant
    if ($donnees['identifiant'] == $identifiant) {
        setcookie("erreur","identifiant");
        header('Location: inscription_user.php'); // Redirection vers le formulaire
        exit(); // Termine le script
        // Si les champs sont vides alors le cookie erreur est crée et vaut vide
    } else if ($identifiant == "" || $mdp == "") {
        setcookie("erreur","vide");
        header('Location: inscription_user.php'); // Redirection vers le formulaire
        exit(); // Termine le script
    }
}
// Si il y a pas d'erreur alors l'utilisateur est crée 
if (!isset($_COOKIE['erreur'])) {
    $sql->query("INSERT INTO utilisateurs(identifiant,mdp,statut) VALUES ('$identifiant', '$mdp', '$statut')");

}
header('Location: ../../index.php'); // Redirection vers le formulaire de connexion
?>