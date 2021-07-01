<?php
// Si le cookie n'existe pas, il est crée et vaut Nouveau
if (!isset($_COOKIE['experience'])) setcookie('experience', 'Nouveau');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expériences professionnelles - Gestion des compétences</title>
    <link rel="stylesheet" href="../../images_css/informations_user.css">
    <link rel="icon" type="image/gif" href="../../images_css/favicon.ico">
</head>
<body>
    <?php
    require('../../extrait_code/header.php'); // Header
    ?>
    <div class="main">
        <?php
        // Si le cookie experience existe et ne vaut pas Nouveau alors le contenu du cookie
        // est affiché pour montrer a l'utilisateur sur quelle expérience il est
        if (isset($_COOKIE['experience']) && $_COOKIE['experience'] != "Nouveau") {
        ?>
        <h1><?php echo "Vous modifier l'éxpérience professionnelle : <br />".$_COOKIE['experience']; ?></h1>
        <?php
        } // Sinon si le cookie vaut Nouveau alors il affiche un autre mesage
        if (isset($_COOKIE['experience']) && $_COOKIE['experience'] == "Nouveau") {
        ?>
        <h1><?php echo "Créer une nouvelle expérience professionelle" ?></h1>
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
            $cookieExp = $_COOKIE['experience'];
            // Requête qui recupère l'id de l'utilisateur
            $chercherId = $sql->query("SELECT id,identifiant FROM utilisateurs WHERE identifiant='$identifiant'");
            while ($donnees = $chercherId->fetch()) $id = $donnees['id'];
            // Requête qui recupère les informations de l'utilisateur
            $requete = $sql->query("SELECT * FROM experience WHERE id_experience=$id AND descriptif='".$cookieExp."'");
            // Les informations sont stockés dans des variables
            while ($donnees = $requete->fetch()) {
                $dateDebut = $donnees['dateDebut'];
                $dateFin = $donnees['dateFin'];
                $descriptif = $donnees['descriptif'];
                $competencesAcquises = $donnees['competencesAcquises'];
                $entreprise = $donnees['entreprise'];
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
                    <p>Descriptif</p>
                    <br />
                    <input class="zoneText" name="descriptif" value="<?php echo $descriptif; ?>" />
                </td>
                <td>
                    <p>Compétences Acquises</p>
                    <br />
                    <textarea name="competencesAcquises"><?php echo $competencesAcquises; ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Entreprise</p>
                    <br />
                    <input class="zoneText" name="entreprise" value="<?php echo $entreprise; ?>" />
                </td>
            </tr>
            </table>
            <br /><br />
            <button>Envoyer</button>
            <br /><br />
        </form>
        <h1 class="liste">Listes de vos expériences</h1>
        <br /><br />
        <div class="liste">
            <?php
            // Le cookie identifiant est stocké dans une variable
            $identifiant = $_COOKIE['identifiant'];
            // Requête qui recupère l'id de l'utilisateur
            $req = $sql->query("SELECT id FROM utilisateurs WHERE identifiant='$identifiant'");
            while ($donnees = $req->fetch()) $idExperience = $donnees['id'];
            // Requête qui recupère dans l'ordre alphabétique les informations de l'utilisateur
            $requete = $sql->query("SELECT id_experience,descriptif,dateDebut FROM experience WHERE id_experience=$id ORDER BY dateDebut");

            while ($donnees = $requete->fetch()) {
            ?>
            <p class="information" onclick="activationCookies(this.innerText)"><?php echo $donnees['descriptif']; ?></p>
            <?php
            }
            ?>
            <p class="nouvelleInformation" onclick="activationCookies('Nouveau')">Créer une nouvelle expérience</p>
        </div>
        <br /><br /><br />
    </div>
    <script type="text/javascript">
        function activationCookies(text) {
            document.location.href = "https://jpo-vif.alwaysdata.net"+window.location.pathname;
            document.cookie= 'experience='+text;
        }
    </script>
</body>
</html>