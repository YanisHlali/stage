<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../../images_css/style.css">
    <link rel="icon" type="image/gif" href="../../images_css/favicon.ico">
</head>
<body>
    <div class="header">
        <a href="../../index.php"><img src="../../images_css/logo.png" /></a>
    </div>
    <form action="traitement_inscription_user.php" method="post">
    <h1>Inscription</h1>
        <br />
        <input type="text" name="identifiant" placeholder="Ecrivez votre identifiant"/>
        <br />
        <input type="password" name="mdp" placeholder="Ecrivez votre mot de passe"/>
        <br />
        <button>Envoyez</button>
        <br />
        <?php // Si le cookie erreur existe, il affiche un message d'erreur en fonction
        // de l'erreur
        if (isset($_COOKIE['erreur'])) {
        ?>
        <p class="erreur"><?php if ($_COOKIE['erreur'] == "vide") { // Si cookie vaut vide
            echo "Les champs sont vides"; // Alors ce message d'erreur est affiché
        }
        if ($_COOKIE['erreur'] == "identifiant") { // Si cookie vaut identifiant
            echo "L'identifiant est déjà utilisé"; // Alors ce message d'erreur est affiché
        } ?></p>
        <?php // Le cookie est supprimé car inutile
            setcookie('erreur', false);
        }
        ?>
    </form>
</body>
</html>