<?php

namespace ApiBundle\Tests\Entity;

use ApiBundle\Entity\Model;
use ApiBundle\Entity\Order;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Unit tests for Order entity
 */
class OrderTest extends WebTestCase
{
    public function testAttributesOrderObject()
    {
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
        $dt = new \DateTime();

        $order = (new Order)
            ->setId(1)
            ->setAmount(35.20)
            ->setCreated($dt)
            ->setModel($model);

        $this->assertEquals(1, $order->getId());
        $this->assertEquals(35.20, $order->getAmount());
        $this->assertInstanceOf(\DateTime::class, $order->getCreated());
        $this->assertEquals($dt, $order->getCreated());

        $expectedModel = (new Model)
            ->setBrand($model['brand'])
            ->setPrice($model['price'])
            ->setId($model['id'])
            ->setName($model['name']);
        $this->assertEquals($expectedModel, $order->getModel());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testOrderWithEmptyModelExpectedRuntimeException()
    {
        $model = [];

        $order = (new Order)
            ->setId(1)
            ->setAmount(35.20)
            ->setCreated(new \DateTime())
            ->setModel($model);
    }
}
