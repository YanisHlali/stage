<?php
require('../../extrait_code/connexion.php'); // Connexion à la base
$identifiant = $_COOKIE['identifiant']; // Crée le cookie identifiant et vaut identifiant
$requete = $sql->query("SELECT id FROM utilisateurs WHERE identifiant='".$identifiant."'");
// Affecte la variable $id a l'id
while ($donnees = $requete->fetch()) $id = $donnees['id'];
// Si le cookie formation existe, il est stocké dans une variable
if (isset($_COOKIE['formation'])) $intituleChoisi = $_COOKIE['formation'];
// Si le cookie n'existe pas, on crée un cookie qui vaut Nouveau et est stocké dans une variable
if (!isset($_COOKIE['formation'])) {
    setcookie('formation', 'Nouveau');
    $intituleChoisi = $_COOKIE['formation'];
}
// Fonction met a jour les données en fonction des valeurs envoyés par le formulaire
function mettreAJour($sql,$ligne,$id,$intituleChoisi) {
    $requete = $sql->query("SELECT $ligne,intitule FROM formation");
    while ($donnees = $requete->fetch()) {
        if ($_POST[$ligne] == date('Y-m-d')) $_POST[$ligne] = "Aujourd\'hui";
        if ($_POST[$ligne] != "" && $intituleChoisi == $donnees['intitule']) $requeteUpdate = $sql->query("UPDATE formation SET $ligne='$_POST[$ligne]' WHERE id_formation=$id AND intitule='$intituleChoisi'");
    }
}
// Fonction qui affiche un pop-up
function popUp($phrase,$descriptif) {
    // Phrase choisi en fonction de la variable $phrase
    if ($phrase == 1) $texte = "enregistré une nouvelle";
    else if ($phrase == 2) $texte = "modifié une ";
    else $texte = "supprimé une ";
    setcookie('formation', "Nouveau"); // La valeur du cookie devient obsolète donc sa valeur est Nouveau
    // Affichage du pop-up
    echo "<script type='text/javascript'>
    alert('Vous avez ".$texte." formation : ".$descriptif."');
    document.location.href = 'https://jpo-vif.alwaysdata.net/Mission_4/user/formation/formulaire.php';
    </script>";
}
// Requête qui recupère les valeurs de l'utilisateur si l'utilisateur n'a pas d'informations
// dans la table formation
$result = $sql->query("SELECT EXISTS (SELECT * FROM formation WHERE id_formation=$id) AS formationExiste");

while ($donnees = $result->fetch()) {
        // Si l'utilisateur n'existe pas ou que le cookie vaut Nouveau ou que le champ intitulé est vide
    if(!$donnees['formationExiste'] || $intituleChoisi == "Nouveau" && $_POST['intitule'] != "") {
        // Requête qui insert les informations dans la base de données
        $requeteInsert = $sql->prepare("INSERT INTO formation(id_formation,dateDebut,dateFin,intitule,competencesAcquises,organisme) 
        VALUES (:id,:dateDebut,:dateFin,:intitule,:competencesAcquises,:organisme)");
        $requeteInsert->bindParam(':id',$id);
        $requeteInsert->bindParam(':dateDebut', $_POST['dateDebut']);
        $requeteInsert->bindParam(':dateFin', $_POST['dateFin']);
        $requeteInsert->bindParam(':intitule',$_POST['intitule']);
        $requeteInsert->bindParam(':competencesAcquises',$_POST['competencesAcquises']);
        $requeteInsert->bindParam(':organisme',$_POST['organisme']);
        $requeteInsert->execute();
        popUp(1, $_POST['intitule']); // Affichage du pop-up
    } else {
        if ($_POST['intitule'] != "") {
            mettreAJour($sql,'dateDebut',$id,$intituleChoisi);
            mettreAJour($sql,'dateFin',$id,$intituleChoisi);
            mettreAJour($sql,'intitule',$id,$intituleChoisi);
            mettreAJour($sql,'competencesAcquises',$id,$intituleChoisi);
            mettreAJour($sql,'organisme',$id,$intituleChoisi);
            popUp(2, $_POST['intitule']);  // Affichage du pop-up
        }
    }
    // Si tous les champs sont vides alors la formation est supprimé
    if ($_POST['intitule'] == "" && $_POST['competencesAcquises'] == "" && $_POST['organisme'] == "") {
        $intitule = $_POST['intitule'];
        popUp(3, $intituleChoisi);  // Affichage du pop-up
        $sql->query("DELETE FROM formation WHERE id_formation=$id AND intitule='$intituleChoisi'");
    }
}
?>