<?php

namespace App\Controller\Etudiant;

use App\Repository\CompteEtudiantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\OffreService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/etudiant/tableau_de_bord')]
class TableauDeBordController extends AbstractController {

    #[Route('/', name: 'app_etudiant_tableau_de_bord_index', methods: ['GET'])]
    public function index(Security $security): Response {
        return $this->render('Tableau_de_bord/index.html.twig', [
                    'comptes' => [$security->getUser()],
        ]);
    }

    #[Route('/show', name: 'app_etudiant_tableau_de_bord_show', methods: ['GET'])]
    public function show(OffreService $offreService, Security $security): Response {
        $compte=$security->getUser();
        return $this->render('Tableau_de_bord/show.html.twig', [
                    'compte' => $compte,
            'offresByCompte' => $offreService->getOffreByCompte($compte),
        ]);
    }

}
