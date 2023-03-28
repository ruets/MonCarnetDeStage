<?php

namespace App\Service;

use App\Controller\Admin\EntrepriseController;
use App\Entity\Offre;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Filesystem\Exception\IOException;

class ConversionService
{

    private EntrepriseRepository $entrepriseRepository;

    public function __construct() {
        $entityManager = new EntityManager();
        $entrepriseRepository = $entityManager->getEntity(Entreprise::class);
        $csv = $this->convertCSVToArray("./test.csv");
        $this->convertArrayToOffre($csv, $entrepriseRepository);
    }

    /**
     * Récupère un fichier CSV à partir d'une url et renvoie un tableau contenant les éléments
     *
     * FORMAT DU FICHIER :
     *  intitule; description; date de dépot (YYYY/MM/JJ); mots-cles; url-piece-jointe; Nom_entreprise; ville; pays
     *
     * @param $filePath     Le chemin du fichier
     * @return array|null   Le tableau si tout fonctionne, null en cas d'erreur
     */
    public function convertCSVToArray($filePath) : array | null {
        try {
            //Ouvre le fichier csv en lecture
            //On le transforme en array
            $file = fopen($filePath, "r");
            return fgetcsv($file,null,";");
        } catch (IOException) {
            //Si il y a une erreur, on renvoie null
            return null;
        }
    }

    public function convertArrayToOffre($array, EntrepriseRepository $entrepriseRepository) : void{

        $intitule = $array[0];
        $description = $array[1];
        $date = getdate(strtotime($array[2]));
        $motscles = $array[3];
        $urlPieceJointe = $array[4];
        $raisonsociale = $array[5];
        $ville = $array[6];
        $pays = $array[7];

        $entreprise = $this->entrepriseRepository->findOneByRaisonSociale($raisonsociale);

        print("go");

        // Trouver l'entreprise ou la créer

    }

}
$conversion = new ConversionService();