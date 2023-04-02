<?php

namespace App\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\CompteEtudiantRepository;

class CompteEtudiantAndEtudiantControllerTest extends WebTestCase
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

        $crawler = $client->request('GET', '/admin/compte_etudiant/');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('CompteEtudiant index');;
    }

    public function testNewEtudiant(): void
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

        $crawler = $client->request('GET', '/admin/etudiant/new');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Nouveau·elle Etudiant');

        $crawler = $client->submitForm('Enregistrer',[
            'etudiant[numeroINE]' => '0000000000F',
            'etudiant[nom]' => 'SaintTest',
            'etudiant[prenom]' => 'JeanTest',
            'etudiant[email]' => 'test@faittontest.fr',
        ]);

        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Etudiant index');
    }

    public function testNewCompteEtudiant(): void
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

        $crawler = $client->request('GET', '/admin/compte_etudiant/new');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Nouveau·elle CompteEtudiant');

        $crawler = $client->submitForm('Enregistrer',[
            'compte_etudiant[etudiant]' => '11',
            'compte_etudiant[login]' => 'testtest',
            'compte_etudiant[password]' => 'test123',
            'compte_etudiant[role]' => 'ROLE_ETUDIANT',
            'compte_etudiant[parcours]' => '*',
            'compte_etudiant[etatRecherche]' => '1',
        ]);

        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('CompteEtudiant index');
    }

    public function testShowCompteEtudiant(): void
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

        $crawler = $client->request('GET', '/admin/compte_etudiant/1');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Stages');
    }

    public function testDeleteCompteEtudiant(): void
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

        $crawler = $client->request('POST', '/admin/compte_etudiant/12');

        $this->assertResponseIsSuccessful();
        
        $crawler = $client->followRedirect();
        $this->assertPageTitleContains('CompteEtudiant index');
    }

    public function testDeleteEtudiant(): void
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

        $crawler = $client->request('POST', '/admin/etudiant/11');

        $this->assertResponseIsSuccessful();
        
        $crawler = $client->followRedirect();
        $this->assertPageTitleContains('Etudiant index');
    }
}
