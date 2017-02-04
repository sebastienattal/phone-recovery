<?php

namespace ApiBundle\Tests\Service;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Unit tests for Json parser
 */
class JsonParserTest extends WebTestCase
{
    public function testDecodeInexistingJsonFile()
    {
        $client = static::createClient();
        $filePath = $client->getKernel()->getRootDir() . '/../data/inexistingFile.json';

        $response = $client->getContainer()->get('json_parser')->decode($filePath);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testDecodeWrongFormattedJsonFile()
    {
        $client = static::createClient();
        $filePath = $client->getKernel()->getRootDir() . '/../data/testInvalidFile.json';

        $response = $client->getContainer()->get('json_parser')->decode($filePath);

        $expectedData = ['message' => 'Control character error, possibly incorrectly encoded'];
        $expectedResponse = new JsonResponse($expectedData, 400);

        $this->assertEquals($expectedResponse, $response);
    }

    public function testDecodeValidJsonFile()
    {
        $client = static::createClient();
        $filePath = $client->getKernel()->getRootDir() . '/../data/testValidFile.json';

        $response = $client->getContainer()->get('json_parser')->decode($filePath);

        $firstItem = new \stdClass();
        $firstItem->id = 1;
        $firstItem->name = 'Name 1';
        $secondItem = new \stdClass();
        $secondItem->id = 2;
        $secondItem->name = 'Name 2';

        $this->assertEquals([$firstItem, $secondItem], $response);
    }
}
