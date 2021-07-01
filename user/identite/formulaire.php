<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identité - Gestion des compétences</title>
    <link rel="stylesheet" href="../../images_css/informations_user.css">
    <link rel="icon" type="image/gif" href="../../images_css/favicon.ico">
</head>
<body>
    <?php
    require('../../extrait_code/header.php'); // Header
    ?>
    <div class="main">
        <h1>Fiche d'identité</h1>
        <br />
        <form action="traitement.php" method="post">
            <table>
            <?php
            require('../../extrait_code/connexion.php'); // Connexion à la base
            // Crée le cookie identifiant qui vaut l'identifiant
            $identifiant = $_COOKIE['identifiant'];
            // Requête qui récupère l'id de l'utilisateur
            $chercherId = $sql->query("SELECT id,identifiant FROM utilisateurs WHERE identifiant='$identifiant'");
            // Exécute la requête et affecte la variable $id à l'id
            while ($donnees = $chercherId->fetch()) $id = $donnees['id'];
            // Requête qui récupère les informations de l'utilisateur
            $requete = $sql->query("SELECT * FROM identite WHERE id_identite=$id");
            while ($donnees = $requete->fetch()) {
                // Affecte les informations de l'utilisateur à des variables
                $nom = $donnees['nom'];
                $prenom = $donnees['prenom'];
                $intitule = $donnees['intitule'];
                $dateDeNaissance = $donnees['dateDeNaissance'];
                $dateEntree = $donnees['dateEntree'];
            }
            ?>
            <tr>
                <td>
                    <p>Nom</p>
                    <br />
                    <input class="zoneText" type="text" name="nom" value="<?php echo $nom; ?>" />
                </td>
                <td>
                    <p>Prénom</p>
                    <br />
                    <input class="zoneText" type="text" name="prenom" value="<?php echo $prenom; ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <p>Intitulé</p>
                    <br />
                    <input class="zoneText" type="text" name="intitule" value="<?php echo $intitule; ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <p class="label">Date de naissance : </p>
                    <br /><br />
                    <input type="date" name="dateDeNaissance" value="<?php echo $dateDeNaissance; ?>" />
                </td>
                <td>
                    <p class="label">Date d'entrée à la MFR : </p>
                    <br /><br />
                    <input type="date" name="dateEntree" value="<?php echo $dateEntree; ?>" />
                </td>
            </tr>
            </table>
            <button>Envoyez</button>
            <br /><br />
        </form>
    </div> 
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</body>
</html>