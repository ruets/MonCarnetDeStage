<?php

use Smalot\PdfParser\Parser;

include './../vendor/autoload.php';

$filename = [];
$size = -1;
$fileContent = '';

$raison_sociale_entreprise = '';
$adresse = '';
$description = '';
$motsCles = '';


if(isset($_POST['submit'])) {
   $filename = $_FILES['file']['name'];
   $size = $_FILES['file']['size'];

   $extention = pathinfo($filename, PATHINFO_EXTENSION);
    $parser = new Parser();
    try {

        $file = $_FILES['file']['tmp_name'];
        $pdfFile = $parser->parseFile($file);

        $fileContent = $pdfFile->getText();

        $fileContent = preg_replace("(\t)", "", $fileContent);
        $fileContent = str_replace('Lieu du stage (si différent de l’adresse', "", $fileContent);
        $fileContent = str_replace('précédente) :', "", $fileContent);

        $fileContent = preg_replace('(\r\n+|\r+|\n+)', "", $fileContent);
        $fileContent = str_replace("Proposition d’offre de stage", "", $fileContent);

        $fileContent = str_replace("(Stage d’une durée minimale de 10 semaines avec gratification obligatoire) ", "", $fileContent);
        $fileContent = str_replace("Entreprise/Laboratoire :", "", $fileContent);

        $traitement = explode("Adresse :", $fileContent);
        $raison_sociale_entreprise = $traitement[0];

        $traitementAdresse = explode("Missions principales", $traitement[1]);
        $adresse = $traitementAdresse[0];

        $traitementMissions = explode(" Outils informatiques (Langages, système d’exploitation, etc)", $traitementAdresse[1]);
        $description = $traitementMissions[0];

        $traitementMotsCles = explode("Profil candidat recherché", $traitementMissions[1]);
        $motsCles = $traitementMotsCles[0];

    } catch (Exception $e) {
        print('error');
    }

}

?>
<form enctype="multipart/form-data" method="POST">
    <input name="file" type="file"  />
    <button type="submit" name="submit">Submit</button>
    <p>
        <?php
            if (isset($extention) && $extention == "pdf") {
                echo("Le fichier est en format pdf");
            } else {
                echo ("Veuillez fournir un fichier pdf");
            }
        ?>
    </p>

    <h1>Fiche d'offre</h1>
    <p>Nom de l'entreprise : <?= $raison_sociale_entreprise ?></p>
    <p>Adresse : <?= $adresse?></p>
    <p>Intitulé : Stage développement </p>
    <p>Mots-clés : <?= $motsCles ?> </p>
    <p>Description : <?= $description ?> </p>

</form>
