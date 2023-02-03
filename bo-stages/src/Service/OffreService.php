<?php

namespace App\Service;

use App\Repository\OffreRepository;
use App\Entity\CompteEtudiant;

// Un service pour manipuler les offres de stage
class OffreService {

    private $offreRepository;

    // Constructeur du service : injection des dépendances
    public function __construct(OffreRepository $offreRepository) {
        $this->offreRepository = $offreRepository;
    }

    // Retourne la liste des offres avec pour chaque offre son statut pour $compteEtudiant
    public function getOffreByCompte(CompteEtudiant $compteEtudiant) {
        $offresByEtudiant = [];
        foreach ($this->offreRepository->findAll() as $offre) {
            $offresByEtudiant[$offre->getId()] = [
                "offre" => $offre,
                "ordre" => 4,
                "statut" => "Pas Consultée",
                "candidature" => null
            ];
        }
        foreach ($compteEtudiant->getCandidatures() as $candidature) {
            $offresByEtudiant[$candidature->getOffre()->getId()]["ordre"] = 1;
            $offresByEtudiant[$candidature->getOffre()->getId()]["statut"] = "Candidature";
            $offresByEtudiant[$candidature->getOffre()->getId()]["candidature"] = $candidature;
        }
        foreach ($compteEtudiant->getOffreRetenues() as $offreRetenue) {
            if ($offresByEtudiant[$offreRetenue->getOffre()->getId()]["ordre"] == 4) {
                $offresByEtudiant[$offreRetenue->getOffre()->getId()]["ordre"] = 2;
                $offresByEtudiant[$offreRetenue->getOffre()->getId()]["statut"] = "Retenue";
            }
        }
        foreach ($compteEtudiant->getOffreConsultees() as $offreConsultee) {
            if ($offresByEtudiant[$offreConsultee->getOffre()->getId()]["ordre"] == 4) {
                $offresByEtudiant[$offreConsultee->getOffre()->getId()]["ordre"] = 3;
                $offresByEtudiant[$offreConsultee->getOffre()->getId()]["statut"] = "Consultée";
            }
        }
        return $offresByEtudiant;
    }

}
