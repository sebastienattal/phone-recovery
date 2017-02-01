<?php

namespace ApiBundle\Entity;

/**
 * Entity for models
 */
class Model
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Brand
     */
    protected $brand;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $price;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return Model
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param array $brand
     * @return Model
     * @throws \RuntimeException
     */
    public function setBrand(array $brand)
    {
        if (empty($brand['id'])) {
            throw new \RuntimeException('The brand is corrupted.');
        }

        $brandName = (!empty($brand['name']) ? $brand['name'] : '');

        $brandObj = (new Brand)
            ->setId($brand['id'])
            ->setName($brandName);

        $this->brand = $brandObj;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Model
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Model
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }
}
