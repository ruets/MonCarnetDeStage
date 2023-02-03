<?php

namespace App\Controller\Admin;

use App\Entity\CompteEtudiant;
use App\Repository\CompteEtudiantRepository;
use App\Service\OffreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tableau_de_bord')]
class TableauDeBordController extends AbstractController {

    #[Route('/', name: 'app_admin_tableau_de_bord_index', methods: ['GET'])]
    public function index(CompteEtudiantRepository $compteEtudiantRepository): Response {
        return $this->render('Tableau_de_bord/index.html.twig', [
                    'comptes' => $compteEtudiantRepository->findAll(),
        ]);
    }

    #[Route('/show/{id}', name: 'app_admin_tableau_de_bord_show', methods: ['GET'])]
    public function show(OffreService $offreService, CompteEtudiant $compte): Response {
        
        return $this->render('Tableau_de_bord/show.html.twig', [
                    'compte' => $compte,
            'offresByCompte' => $offreService->getOffreByCompte($compte),
        ]);
    }

}
