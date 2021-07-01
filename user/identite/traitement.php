<?php
require('../../extrait_code/connexion.php'); // Connexion à la base

$identifiant = $_COOKIE['identifiant']; // Crée le cookie identifiant et vaut identifiant
// Requête qui récupère l'id de l'utilisateur
$requete = $sql->query("SELECT id FROM utilisateurs WHERE identifiant='".$identifiant."'");
// Exécute la requête et affecte la variable $id à l'id
$id = 0;
while ($donnees = $requete->fetch()) $id = $donnees['id'];
// Fonction met a jour les données en fonction des valeurs envoyés par le formulaire
function mettreAJour($sql,$ligne,$id) {
    $requete = $sql->query("SELECT $ligne FROM identite");
    while ($donnees = $requete->fetch()) {
        if ($_POST[$ligne] != "") {
            $requeteUpdate = $sql->query("UPDATE identite SET $ligne='$_POST[$ligne]' WHERE id_identite=$id");
        }
    }
}
// Requête qui recupère les valeurs de l'utilisateur si l'utilisateur n'a pas d'informations
// dans la table identité
$result = $sql->query("SELECT EXISTS (SELECT * FROM identite WHERE id_identite=$id) AS identiteExiste");

while ($donnees = $result->fetch()) {
    if(!$donnees['identiteExiste']) { // Si l'utilisateur n'existe pas
        // Requête qui insert les informations dans la base de données
        $requeteInsert = $sql->prepare("INSERT INTO identite(id_identite,nom,prenom,dateDeNaissance,intitule,dateEntree) 
        VALUES (:id,:nom,:prenom,:dateDeNaissance,:intitule,:dateEntree)");
        $requeteInsert->bindParam(':id',$id);
        $requeteInsert->bindParam(':nom', $_POST['nom']);
        $requeteInsert->bindParam(':prenom', $_POST['prenom']);
        $requeteInsert->bindParam(':dateDeNaissance', $_POST['dateDeNaissance']);
        $requeteInsert->bindParam(':intitule',$_POST['intitule']);
        $requeteInsert->bindParam(':dateEntree',$_POST['dateEntree']);
        $requeteInsert->execute();
    } else { // Remplace les précedentes données par les nouvelles
        mettreAJour($sql,'nom',$id);
        mettreAJour($sql,'prenom',$id);
        mettreAJour($sql,'dateDeNaissance',$id);
        mettreAJour($sql,'intitule',$id);
        mettreAJour($sql,'dateEntree',$id);
    }
}

header('Location: ../experience/formulaire.php'); // Redirection vers le formulaire suivant
?>