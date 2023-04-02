<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\CompteEtudiantRepository;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexNoConnect(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Accueil');
        $this->assertSelectorExists('.button_default');
    }

    public function testIndexConnect(): void
    {
        $client = static::createClient();
        $compteRepository = static::getContainer()->get(CompteEtudiantRepository::class);

        $compteTest = $compteRepository->findAll()[0];
        
        $client->loginUser($compteTest);

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Accueil');
        $this->assertSelectorNotExists('.button_default');
    }

    public function testIndexDisconnect(): void
    {
        $client = static::createClient();
        $compteRepository = static::getContainer()->get(CompteEtudiantRepository::class);

        $compteTest = $compteRepository->findAll()[0];
        
        $client->loginUser($compteTest);

        $client->request('GET', '/logout');

        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Accueil');
        $this->assertSelectorExists('.button_default');
    }
}
