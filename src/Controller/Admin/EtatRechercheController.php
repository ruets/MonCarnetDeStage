<?php

namespace App\Controller\Admin;

use App\Entity\EtatRecherche;
use App\Form\EtatRechercheType;
use App\Repository\EtatRechercheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/etat_recherche')]
class EtatRechercheController extends AbstractController
{
    /**
     * Route permettant a l'administrateur de visualiser l'état des recherches.
     **/
    #[Route('/', name: 'app_etat_recherche_index', methods: ['GET'])]
    public function index(EtatRechercheRepository $etatRechercheRepository): Response
    {
        return $this->render('Admin/etat_recherche/index.html.twig', [
            'etat_recherches' => $etatRechercheRepository->findBy([],["id"=>"ASC"]),
        ]);
    }

    /**
     * Route permettant a l'administrateur d'ajouter un nouvel état pour une recherche.
     **/
    #[Route('/new', name: 'app_etat_recherche_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EtatRechercheRepository $etatRechercheRepository): Response
    {
        $etatRecherche = new EtatRecherche();
        $form = $this->createForm(EtatRechercheType::class, $etatRecherche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etatRechercheRepository->save($etatRecherche, true);

            return $this->redirectToRoute('app_etat_recherche_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/etat_recherche/new.html.twig', [
            'etat_recherche' => $etatRecherche,
            'form' => $form,
        ]);
    }

    /**
     * Route permettant a l'administrateur de visualiser les données de l'état d'une recherche en fonction de son id.
     **/
    #[Route('/{id}', name: 'app_etat_recherche_show', methods: ['GET'])]
    public function show(EtatRecherche $etatRecherche): Response
    {
        return $this->render('Admin/etat_recherche/show.html.twig', [
            'etat_recherche' => $etatRecherche,
        ]);
    }

    /**
     * Route permettant a l'administrateur d'éditer les données de l'état d'une recherche en fonction de son id .
     **/
    #[Route('/{id}/edit', name: 'app_etat_recherche_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtatRecherche $etatRecherche, EtatRechercheRepository $etatRechercheRepository): Response
    {
        $form = $this->createForm(EtatRechercheType::class, $etatRecherche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etatRechercheRepository->save($etatRecherche, true);

            return $this->redirectToRoute('app_etat_recherche_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/etat_recherche/edit.html.twig', [
            'etat_recherche' => $etatRecherche,
            'form' => $form,
        ]);
    }

    /**
     * Route permettant a l'administrateur de suppprimer un état d'une recherche en fonction de son id .
     **/
    #[Route('/{id}', name: 'app_etat_recherche_delete', methods: ['POST'])]
    public function delete(Request $request, EtatRecherche $etatRecherche, EtatRechercheRepository $etatRechercheRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etatRecherche->getId(), $request->request->get('_token'))) {
            $etatRechercheRepository->remove($etatRecherche, true);
        }

        return $this->redirectToRoute('app_etat_recherche_index', [], Response::HTTP_SEE_OTHER);
    }
}
