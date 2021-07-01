<?php
require_once __DIR__ . '/vendor/autoload.php';
require('../extrait_code/connexion.php'); // Connexion à la base

$stylesheet = file_get_contents('../images_css/pdf.css'); // Le fichier css
// Extrait de code qui permet d'utiliser des polices
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/Lato',
    ]),
    'fontdata' => $fontData + [
        'lato' => [
            'R' => 'Lato-Regular.ttf',
        ]
    ],
    'default_font' => 'lato'
]);
$mpdf->WriteHTML($stylesheet, 1);
$mpdf->SetDisplayMode('fullpage');

$id = $_GET['id'];
// Requête qui recupère les informations de l'utilisateur
$reqIdentite = $sql->query("SELECT * FROM identite WHERE id_identite=$id");
$reqExperience = $sql->query("SELECT * FROM experience WHERE id_experience=$id");
$reqFormation = $sql->query("SELECT * FROM formation WHERE id_formation=$id");
// Fonction qui convertir les dates en autre format
function conversionDates($laDate) {
    // Si la date vaut Aujourd'hui alors elle n'est pas changé
    if ($laDate == "Aujourd'hui") return $laDate;
    // La date est convertit en tableau
    $lesDates = explode("-", $laDate);
    // Les différents élements du tableau sont stockés dans des variables
    $annee = $lesDates[0];
    $mois = $lesDates[1];
    $jour = $lesDates[2];
    // Le mois est changé par le nom du mois
    $lesMois = ['janvier','février','mars','avril','mai','juin',
    'juillet','août','septembre','octobre','novembre','decembre'];
    for ($i = 0; $i < count($lesMois); $i++) {
        if ($mois == '0'.$i+1) {
            $mois = $lesMois[$i];
        }
    }
    // Le 0 du jour est supprimé
    for ($i = 0; $i < 10; $i++) {
        if ($jour == '0'+$i) {
            $jour = $i;
        }
    }
    $dateFinal = $jour." ".$mois." ".$annee;
    return $dateFinal;
}
// La partie identité
while ($donnees = $reqIdentite->fetch()) {
    // Affichage des informations de l'utilisateur
    $dateDeNaissance = conversionDates($donnees['dateDeNaissance']);
    $dateEntree = conversionDates($donnees['dateEntree']);
    $titrePdf = strtoupper($donnees['nom']).'-'.$donnees['prenom'];
    $nom = "<h1>".$donnees['nom']." ".$donnees['prenom']."</h1>";
    $mpdf->WriteHTML($nom);
    $intitule = "<p class='intitule'>".$donnees['intitule']."</p>";
    $mpdf->WriteHTML($intitule);
    $age = "<p class='intitule'>".$dateDeNaissance."</p>";
    $mpdf->WriteHTML($age);
    $dateEntree = "<p class='intitule'>A la MFR depuis le ".$dateEntree."</p>";
    $mpdf->WriteHTML($dateEntree);
}

// La partie expérience
$titreExperience = "<h1 class='categorie'>Expériences Professionnelles</h1>";
$mpdf->WriteHTML($titreExperience);
while ($donnees = $reqExperience->fetch()) {
    // Affichage des informations de l'utilisateur
    $dateDebut = conversionDates($donnees['dateDebut']);
    $dateFin = conversionDates($donnees['dateFin']);
    $descriptif = "<p class='experience'>".$donnees['descriptif']." - ".$donnees['entreprise']."</p>";
    $mpdf->WriteHTML($descriptif);
    $dates = "<p>".$dateDebut." - ".$dateFin."</p>";
    $mpdf->WriteHTML($dates);
    $competences = "<p>Compétences Acquises : ".$donnees['competencesAcquises']."</p>";
    $mpdf->WriteHTML($competences);
}
// La partie formation
$titreFormation = "<h1 class='categorie'>Formation</h1>";
$mpdf->WriteHTML($titreFormation);
while ($donnees = $reqFormation->fetch()) {
    // Si les dates sont celles d'aujourd'hui alors elles sont convertit
    if ($donnnees['dateDebut'] == date('Y-m-d')) {
       $dateDebut = conversionDates($donnees['dateDebut']);
    }
    if ($donnnees['dateFin'] == date('Y-m-d')) {
        $dateFin = conversionDates($donnees['dateFin']);
    }
    $intitule = "<p class='experience'>".$donnees['intitule']." - ".$donnees['organisme']."</p>";
    $mpdf->WriteHTML($intitule);
    $dates = "<p>".$dateDebut." - ".$dateFin."</p>";
    $mpdf->WriteHTML($dates);
    $competences = "<p>Compétences Acquises : ".$donnees['competencesAcquises']."</p>";
    $mpdf->WriteHTML($competences);
}
$mpdf->Output('CV_'.$titrePdf.'.pdf', 'D');
?>