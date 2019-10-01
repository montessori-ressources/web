<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClassifiedCardControllerTest extends WebTestCase
{
    public function test_homepage_must_show_page_title()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('MONTESSORI RESSOURCES', $crawler->filter('h1')->text());
    }

    public function test_upload_anonymous_must_return_unauthorized()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/nomenclature/new');
        $this->assertSame(401, $client->getResponse()->getStatusCode());
    }

    public function test_upload_user_must_return_form()
    {
        // how to have
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'user',
        ]);
        $crawler = $client->request('GET', '/nomenclature/new');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Create a Nomenclature', $crawler->filter('h1')->text());
    }

    public function test_admin_anonymous_must_return_unauthorized()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/');
        $this->assertSame(401, $client->getResponse()->getStatusCode());
    }

    public function test_admin_user_must_return_unauthorized()
    {
        // how to have
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'user',
        ]);
        $crawler = $client->request('GET', '/admin/');
        $this->assertSame(403, $client->getResponse()->getStatusCode());

    }

    public function test_admin_admin_must_return_admin()
    {
        // how to have
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ]);
        $crawler = $client->request('GET', '/admin/?action=list&entity=Image');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Image', $crawler->filter('h1')->text());
    }
}
