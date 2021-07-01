<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste formateurs - Gestion des compétences</title>
    <link rel="stylesheet" href="../images_css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.71/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.71/vfs_fonts.js"></script>
    <link rel="icon" type="image/gif" href="../images_css/favicon.ico">
</head>
<body>
    <div class="header">
        <a href="../index.php"><img src="../images_css/logo.png" /></a>
    </div>
    <?php
        require('../extrait_code/connexion.php');

        $req = $sql->query("SELECT id_identite,nom,prenom FROM identite ORDER BY nom");
        ?>
    <form>
        <h1>Listes formateurs</h1>
        <br />
        <table>
            <?php
            while ($donnees = $req->fetch()) {
                $id = $donnees['id_identite'];
            ?>
            <tr>
                <td><a href="mpdf.php?id=<?php echo $id; ?>"><?php echo $donnees['prenom']." ".$donnees['nom']; ?></a></td>
                <td><a href="suppression.php?id=<?php echo $id; ?>"><img class="croix" src="../images_css/croix.png" /></a></td>
            </tr>
            <?php
            }
            ?>
        </table>
    <br /><br />
    <?php
    ?>
    <br />
    </form>
    <?php
    ?>
</body>
</html>