<?php

namespace ApiBundle\Tests\Entity;

use ApiBundle\Entity\Brand;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Unit tests for Brand entity
 */
class BrandTest extends WebTestCase
{
    public function testAttributesBrandObject()
    {
        $brand = (new Brand)
            ->setId(1)
            ->setName('Brand name');

        $this->assertEquals(1, $brand->getId());
        $this->assertEquals('Brand name', $brand->getName());
    }
}
