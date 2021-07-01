<?php
// Les cookies sont supprimés pour éviter que si l'utilisateur entre ses informations
// sur le même navigateur qu'un autre utilisateur il puisse avoir accès aux cookies
if (isset($_COOKIE['experience'])) setcookie('experience');
if (isset($_COOKIE['formation'])) setcookie('formation');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aide - Gestion des compétences</title>
    <link rel="stylesheet" href="../images_css/informations_user.css">
    <link rel="icon" type="image/gif" href="../images_css/favicon.ico">
</head>
<body>
    <div class="header">
    <a href="../index.php"><img src="../images_css/logo.png" /></a>
        <nav>
            <ul>
                <li><a href="identite/formulaire.php">Identité</a></li>
                <li><a href="experience/formulaire.php">Experience</a></li>
                <li><a href="formation/formulaire.php">Formation</a></li>
            </ul>
        </nav>
    </div>
    <div class="main">
        <h1>Gestion des compétences</h1>
        <br />
        <p><span class="aide">Ajouter</span> une expérience/formation :<br /><br />
        Compléter le formulaire<br />
        Cliquer sur envoyer<br /><br />
        <span class="aide">Modifier</span> une expérience/formation :<br /><br />
        Cliquer sur l'expérience/formation dans la liste en bas de page<br />
        Compléter le formulaire<br /><br />
        <span class="aide">Supprimer</span> une expérience/formation :<br /><br />
        Cliquer sur l'expérience/formation dans la liste en bas de page<br />
        Vider tous les champs du formulaire<br />
        Cliquer sur envoyer</p>
    </div> 
</body>
</html>