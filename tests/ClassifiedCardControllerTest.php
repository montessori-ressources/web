<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClassifiedCardControllerTest extends WebTestCase
{
    public function testHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('MONTESSORI RESSOURCES', $crawler->filter('h1')->text());
    }
}
