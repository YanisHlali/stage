<?php
require('../../extrait_code/connexion.php'); // Connexion à la base
$identifiant = $_COOKIE['identifiant']; // Crée le cookie identifiant et vaut identifiant
// Requête qui recupère l'id de l'utilisateur
$requete = $sql->query("SELECT id FROM utilisateurs WHERE identifiant='".$identifiant."'");
// Affecte la variable $id a l'id
while ($donnees = $requete->fetch()) $id = $donnees['id'];
// Si le cookie formation existe, il est stocké dans une variable
if (isset($_COOKIE['experience'])) $descriptifChoisi = $_COOKIE['experience'];
// Si le cookie n'existe pas, on crée un cookie qui vaut Nouveau et est stocké dans une variable
if (!isset($_COOKIE['experience'])) {
    setcookie('experience', 'Nouveau');
    $descriptifChoisi = $_COOKIE['experience'];
}
// Fonction met a jour les données en fonction des valeurs envoyés par le formulaire
function mettreAJour($sql,$ligne,$id,$descriptifChoisi) {
    $requete = $sql->query("SELECT $ligne,descriptif FROM experience");
    while ($donnees = $requete->fetch()) {
        if ($_POST[$ligne] == date('Y-m-d')) $_POST[$ligne] = "Aujourd\'hui";
        if ($_POST[$ligne] != "" && $descriptifChoisi == $donnees['descriptif']) {
            $sql->query("UPDATE experience SET $ligne='$_POST[$ligne]' WHERE id_experience=$id AND descriptif='$descriptifChoisi'");
        }
    }
}
// Fonction qui affiche un pop-up
function popUp($phrase,$descriptif) {
    // Phrase choisi en fonction de la variable $phrase
    if ($phrase == 1) $texte = "enregistré une nouvelle";
    else if ($phrase == 2) $texte = "modifié une";
    else $texte = "supprimé une";
    setcookie('experience', "Nouveau"); // La valeur du cookie devient obsolète donc sa valeur est Nouveau
    // Affichage du pop-up
    echo "<script type='text/javascript'>
    alert('Vous avez ".$texte." expérience : ".$descriptif."');
    document.location.href = 'https://jpo-vif.alwaysdata.net/Mission_4/user/formation/formulaire.php';
    </script>";
}
// Requête qui recupère les valeurs de l'utilisateur si l'utilisateur n'a pas d'informations
// dans la table formation
$result = $sql->query("SELECT EXISTS (SELECT * FROM experience WHERE id_experience=$id) AS experienceExiste");

while ($donnees = $result->fetch()) {
        // Si l'utilisateur n'existe pas ou que le cookie vaut Nouveau ou que le champ intitulé est vide
    if(!$donnees['experienceExiste'] || $descriptifChoisi == "Nouveau" && $_POST['descriptif'] != "") {
        // Requête qui insert les informations dans la base de données
        $requeteInsert = $sql->prepare("INSERT INTO experience(id_experience,dateDebut,dateFin,descriptif,competencesAcquises,entreprise) 
        VALUES (:id,:dateDebut,:dateFin,:descriptif,:competencesAcquises,:entreprise)");
        $requeteInsert->bindParam(':id',$id);
        $requeteInsert->bindParam(':dateDebut', $_POST['dateDebut']);
        $requeteInsert->bindParam(':dateFin', $_POST['dateFin']);
        $requeteInsert->bindParam(':descriptif',$_POST['descriptif']);
        $requeteInsert->bindParam(':competencesAcquises',$_POST['competencesAcquises']);
        $requeteInsert->bindParam(':entreprise',$_POST['entreprise']);
        $requeteInsert->execute();
        popUp(1, $_POST['descriptif']); // Affichage du pop-up
    } else {
        if ($_POST['descriptif'] != "") {
            mettreAJour($sql,'dateDebut',$id,$descriptifChoisi);
            mettreAJour($sql,'dateFin',$id,$descriptifChoisi);
            mettreAJour($sql,'descriptif',$id,$descriptifChoisi);
            mettreAJour($sql,'competencesAcquises',$id,$descriptifChoisi);
            mettreAJour($sql,'entreprise',$id,$descriptifChoisi);
            popUp(2, $_POST['descriptif']); // Affichage du pop-up
        }
    }
    // Si tous les champs sont vides alors la formation est supprimé
    if ($_POST['descriptif'] == "" && $_POST['competencesAcquises'] == "" && $_POST['entreprise'] == "") {
        $descriptif = $_POST['descriptif'];
        popUp(3, $descriptifChoisi); // Affichage du pop-up
        $sql->query("DELETE FROM experience WHERE id_experience=$id AND descriptif='$descriptifChoisi'");
    }
}
?>