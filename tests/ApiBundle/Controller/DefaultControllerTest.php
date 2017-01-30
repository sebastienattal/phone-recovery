<?php

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/services/list');

        var_dump($client->getResponse()->getContent()); die(__FILE__ . ':' . __LINE__);
        $this->assert('Hello World', $client->getResponse()->getContent());
    }
}
