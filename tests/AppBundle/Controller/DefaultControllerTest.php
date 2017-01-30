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
        $this->assertContains('Welcome to Phone recovery!', $crawler->filter('body > div')->text());
    }
}
