<?php

namespace App\Tests\Controller\Etudiant;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\CompteEtudiantRepository;
use App\Repository\OffreRepository;

class TableauDeBordControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $compteRepository = static::getContainer()->get(CompteEtudiantRepository::class);

        $compteTest = $compteRepository->findAll()[0];
        
        $client->loginUser($compteTest);

        $crawler = $client->request('GET', '/etudiant/tableau_de_bord/');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Tableau de Bord');
    }

    public function testShow(): void
    {
        $client = static::createClient();
        $compteRepository = static::getContainer()->get(CompteEtudiantRepository::class);

        $compteTest = $compteRepository->findAll()[0];
        
        $client->loginUser($compteTest);

        $crawler = $client->request('GET', '/etudiant/tableau_de_bord/show');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Offres par Etudiant');
    }

    public function testShowOffre(): void
    {
        $client = static::createClient();
        $compteRepository = static::getContainer()->get(CompteEtudiantRepository::class);
        $compteTest = $compteRepository->findAll()[0];
        
        $client->loginUser($compteTest);

        /*$offreRepository = static::getContainer()->get(OffreRepository::class);
        $offre = $offreRepository->findAll()[0];
        $offreId = strval($offre->getId());*/
        
        $lienPage = '/etudiant/tableau_de_bord/show/offre2';

        $crawler = $client->request('GET', $lienPage);
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Offre');
    }
}
