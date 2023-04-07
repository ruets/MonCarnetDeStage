<?php

use Smalot\PdfParser\Parser;

include './../vendor/autoload.php';

$filename = [];
$size = -1;
$fileContent = '';


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
        $fileContent = preg_replace('(\r\n+|\r+|\n+)', "\n", $fileContent);

        $fileContent = str_replace("Entreprise/Laboratoire : ", "", $fileContent);
        $fileContent = str_replace("Proposition d’offre de stage", "", $fileContent);
        $fileContent = str_replace("Adresse :", "", $fileContent);
        $fileContent = str_replace("Missions principales", "", $fileContent);

        $fileContent = str_replace("(Stage d’une durée minimale de 10 semaines avec gratification obligatoire) ", "", $fileContent);

        $array = preg_split('(\n+)', $fileContent);


        for($i=1;$i<sizeof($array);$i++) {
            $match = preg_match("/^[1-9]\d{4}$/", $array[$i]);
            if($match && $i >1) {
                $array[$i-1] = $array[$i-1] . $array[$i];
                unset($array[$i]);
            }



            if($array[$i] == ' ') {
                unset($array[$i]);
            }

        }
        $array = array_values($array);

        print_r($array);
        $raison_sociale_entreprise = $array[1];
        $adresse = $array[2];
        $intitule = $array[6];
        $motscles = $array[8];

        $motscles = str_replace('et', "", $motscles);

        $description = $array[13] . $array[14] . $array[15] . $array[16] . $array[17];

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
    <p>Intitulé : <?= $intitule ?> </p>
    <p>Mots-clés : <?= $motscles ?> </p>
    <p>Description : <?= $description ?> </p>

</form>
