<?php

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Unit tests for main controller of the Api Bundle
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

    public function testListAllModels()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/services/models');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
    }

    public function testGetModelByIdReturns200()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/services/models/5');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
    }

    public function testGetModelByIdReturns404()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/services/models/test');

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testGetBrandByIdReturns200()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/services/brands/5');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
    }

    public function testGetBrandByIdReturns404()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/services/brands/test');

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }
}
