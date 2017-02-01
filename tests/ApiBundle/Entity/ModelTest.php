<?php

namespace ApiBundle\Tests\Entity;

use ApiBundle\Entity\Brand;
use ApiBundle\Entity\Model;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Unit tests for Model entity
 */
class ModelTest extends WebTestCase
{
    public function testAttributesModelObject()
    {
        $brand = [
            'id' => 7,
            'name' => 'Brand name'
        ];

        $model = (new Model)
            ->setId(1)
            ->setName('Model name')
            ->setPrice(74.10)
            ->setBrand($brand);

        $this->assertEquals(1, $model->getId());
        $this->assertEquals('Model name', $model->getName());
        $this->assertEquals(74.10, $model->getPrice());
        $this->assertInstanceOf(Brand::class , $model->getBrand());
    }

    /**
     * @expectedException \TypeError
     */
    public function testModelWithNullBrandExpectedTypeError()
    {
        $model = (new Model)
            ->setId(1)
            ->setName('Model name')
            ->setPrice(74.10)
            ->setBrand(null);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testModelWithInvalidBrandExpectedRuntimeException()
    {
        $brand = [
            'name' => 'Wrong brand'
        ];

        $model = (new Model)
            ->setId(1)
            ->setName('Model name')
            ->setPrice(74.10)
            ->setBrand($brand);
    }
}
