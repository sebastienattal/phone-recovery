<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Unit tests for the App Bundle
 */
class DefaultControllerTest extends WebTestCase
{
    public function testDisplayHomepage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Phone recovery!', $crawler->filter('body h1')->text());
    }

    public function testDisplayOrdersList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/list');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDisplayAddOrder()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
