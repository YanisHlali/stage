<?php
// Les cookies sont supprimés pour éviter les erreurs à la connexion
if (isset($_COOKIE['identifiant'])) setcookie('identifiant');
if (isset($_COOKIE['experience'])) setcookie('experience');
if (isset($_COOKIE['formation'])) setcookie('formation');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion des compétences</title>
    <link rel="stylesheet" href="images_css/style.css">
    <link rel="icon" type="image/gif" href="images_css/favicon.ico">
</head>
<body>
    <div class="header">
        <a href="index.php"><img src="images_css/logo.png" /></a>
    </div>

    <form action="traitement.php" method="post">
        <h1>Connexion</h1>
        <br />
        <input type="text" name="identifiant" placeholder="Login"/>
        <br />
        <input type="password" name="mdp" placeholder="Mot de passe"/>
        <br />
        <button>Connexion</button>
        <br />
        <?php // Si le cookie erreur existe, alors un message d'erreur est affiché
        if (isset($_COOKIE['erreur'])) {
            setcookie('erreur', false); // Le cookie est supprimé car il n'est plus utile
        ?>
        <p class="erreur"><?php echo "Vos identifiants sont mauvais"; ?></p>
        <?php
            }
        ?>
        <p><a href="user/inscription/inscription_user.php">Vous n'êtes pas incrit ?</a></p>
    </form>
</body>
</html>