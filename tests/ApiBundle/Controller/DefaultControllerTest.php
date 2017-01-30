<?php

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Unit tests for the Api Bundle
 */
class DefaultControllerTest extends WebTestCase
{
    public function testListAllBrands()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/services/brands');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
    }

    public function testListAllOrders()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/services/orders');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
    }
}
