<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\CompteEtudiantRepository;

class SecurityControllerTest extends WebTestCase
{
    public function testIndexNoConnect(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Log in!');
        $this->assertSelectorNotExists('.nav-item');
    }
    public function testIndexConnect(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertPageTitleContains('Log in!');

        $compteRepository = static::getContainer()->get(CompteEtudiantRepository::class);

        $compteTest = $compteRepository->findAll()[0];
        
        $client->loginUser($compteTest);

        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Log in!');
        $this->assertSelectorExists('.nav-item');
    }
}
