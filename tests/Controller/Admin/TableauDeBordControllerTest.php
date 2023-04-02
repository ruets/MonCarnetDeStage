<?php

namespace App\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\CompteEtudiantRepository;

class TableauDeBordControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $compteRepository = static::getContainer()->get(CompteEtudiantRepository::class);
        $compteTestAdmin = null;
        
        foreach($compteRepository->findAll() as $compteTest){
            if ($compteTest->getRoles()[0] == "ROLE_ADMIN"){
                $compteTestAdmin = $compteTest;
            }
        }
        
        
        $client->loginUser($compteTestAdmin);

        $crawler = $client->request('GET', '/admin/tableau_de_bord/');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Tableau de Bord');
    }

    public function testShow(): void
    {
        $client = static::createClient();
        $compteRepository = static::getContainer()->get(CompteEtudiantRepository::class);

        $compteTestAdmin = null;
        
        foreach($compteRepository->findAll() as $compteTest){
            if ($compteTest->getRoles()[0] == "ROLE_ADMIN"){
                $compteTestAdmin = $compteTest;
            }
        }
        
        $client->loginUser($compteTestAdmin);

        $crawler = $client->request('GET', '/admin/tableau_de_bord/show/2');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Offres par Etudiant');
    }
}
