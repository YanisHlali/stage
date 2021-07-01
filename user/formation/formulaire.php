<?php
// Si le cookie n'existe pas, il est crée et vaut Nouveau
if (!isset($_COOKIE['formation'])) setcookie('formation', 'Nouveau');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formation - Gestion des compétences</title>
    <link rel="stylesheet" href="../../images_css/informations_user.css">
    <link rel="icon" type="image/gif" href="../../images_css/favicon.ico">
</head>
<body>
    <?php
    require('../../extrait_code/header.php'); // Header
    ?>
    <div class="main">
    <?php
        // Si le cookie formation existe et ne vaut pas Nouveau alors le contenu du cookie
        // est affiché pour montrer a l'utilisateur sur quelle formation il est
        if (isset($_COOKIE['formation']) && $_COOKIE['formation'] != "Nouveau") {
        ?>
        <h1><?php echo "Formation: <br />".$_COOKIE['formation']; ?></h1>
        <?php
        } // Sinon si le cookie vaut Nouveau alors il affiche un autre mesage
        if (isset($_COOKIE['formation']) && $_COOKIE['formation'] == "Nouveau") {
        ?>
        <h1><?php echo "Créer une nouvelle formation" ?></h1>
        <?php
        }
        ?>
        <br /><br /><br />
        <form action="traitement.php" method="post">
            <table>
            <?php
            require('../../extrait_code/connexion.php'); // Connexion à la base
            // Les cookies sont stockés dans des variables
            $identifiant = $_COOKIE['identifiant'];
            $formation = $_COOKIE['formation'];
            // Requête qui recupère l'id de l'utilisateur
            $chercherId = $sql->query("SELECT id,identifiant FROM utilisateurs WHERE identifiant='$identifiant'");
            while ($donnees = $chercherId->fetch()) $id = $donnees['id'];
            // Requête qui recupère les informations de l'utilsiateur
            $requete = $sql->query("SELECT * FROM formation WHERE id_formation=$id AND intitule='".$formation."'");
            // Les informations sont stockés dans des variables
            while ($donnees = $requete->fetch()) {
                $dateDebut = $donnees['dateDebut'];
                $dateFin = $donnees['dateFin'];
                $intitule = $donnees['intitule'];
                $organisme = $donnees['organisme'];
                $competencesAcquises = $donnees['competencesAcquises'];
            }
            ?>
            <tr>
                <td>
                    <p class="label">Date de début : </p>
                    <br /><br />
                    <input type="date" name="dateDebut" value="<?php echo $dateDebut; ?>" />
                </td>
                <td>
                    <p class="label">Date de fin : </p>
                    <br /><br />
                    <input type="date" name="dateFin" value="<?php echo $dateFin; ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <p>Intitulé</p>
                    <br />
                    <input class="zoneText" name="intitule" value="<?php echo $intitule; ?>" />
                </td>
                <td>
                    <p>Competences acquises</p>
                    <br />
                    <textarea name="competencesAcquises"><?php echo $competencesAcquises; ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Organisme</p>
                    <br />
                    <input class="zoneText" name="organisme" value="<?php echo $organisme; ?>" />
                </td>
            </tr>
            </table>
            <button>Envoyer</button>
            <br /><br />
        </form>
        <h1>Listes de vos formations</h1>
        <br /><br />
        <div class="liste">
            <?php
            // Le cookie identifiant est stocké dans une variable
            $identifiant = $_COOKIE['identifiant'];
            // Requête qui recupère l'id de l'utilisateur
            $req = $sql->query("SELECT id FROM utilisateurs WHERE identifiant='$identifiant'");
            while ($donnees = $req->fetch()) $idFormation = $donnees['id'];
            // Requête qui recupère dans l'ordre alphabétique les informations de l'utilisateur
            $requete = $sql->query("SELECT intitule, dateDebut FROM formation WHERE id_formation=$idFormation ORDER BY dateDebut");

            while ($donnees = $requete->fetch()) {
            ?>
            <p class="information" onclick="activationCookies(this.innerText)"><?php echo $donnees['intitule']; ?></p>
            <?php
            }
            ?>
            <p class="nouvelleInformation" onclick="activationCookies('Nouveau')">Créer une nouvelle information</p>
        </div>
        <br /><br /><br />
    </div>
    <br /><br /><br />
    <script type="text/javascript">
        // Fonction qui change le cookie et rafraichit la page
        function activationCookies(text) {
            document.cookie= 'formation='+text;
            document.location.href = "https://jpo-vif.alwaysdata.net/Mission_4/user/formation/formulaire.php";
        }
    </script>
    <br /><br /><br />
</body>
</html>