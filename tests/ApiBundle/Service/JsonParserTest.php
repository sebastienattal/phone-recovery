<?php

namespace ApiBundle\Tests\Service;

use ApiBundle\Entity\Order;
use ApiBundle\Service\JsonParser;
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

    public function testSaveOrder()
    {
        $client = static::createClient();
        $filePath = $client->getKernel()->getRootDir() . '/../data/testOrderFile.json';

        file_put_contents($filePath, '[]');

        $brand = [
            'id' => 1,
            'name' => 'Brand test'
        ];
        $model = [
            'id' => 1,
            'name' => 'Model test',
            'price' => 78,
            'brand' => $brand
        ];
        $dt = (new \DateTime)->format('Y-m-d H:i:s');

        $order = (new Order)
            ->setId(1)
            ->setAmount(35.20)
            ->setCreated($dt)
            ->setModel($model);

        $jsonParser = $this
            ->getMockBuilder(JsonParser::class)
            ->disableOriginalConstructor()
            ->setMethods(['decode'])
            ->getMock();

        $jsonParser
            ->expects($this->once())
            ->method('decode')
            ->will($this->returnValue([]));

        $response = $jsonParser->saveOrder($order, $filePath);
        $jsonResponse = json_decode($response->getContent());

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('The order has been successfully created!', $jsonResponse->message);
        $this->assertContains('"id":1,"model":1,"amount":35.2', file_get_contents($filePath));

        file_put_contents($filePath, '[]');
    }
}
