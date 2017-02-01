<?php

namespace ApiBundle\Entity;

/**
 * Entity for orders
 */
class Order
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param array $model
     * @return Order
     * @throws \RuntimeException
     */
    public function setModel(array $model)
    {
        if (empty($model['id'])) {
            throw new \RuntimeException('The model is corrupted.');
        }

        $modelName = (!empty($model['name']) ? $model['name'] : '');
        $modelBrand = (!empty($model['brand']) ? $model['brand'] : []);
        $modelPrice = (!empty($model['price']) ? $model['price'] : 0);

        $objModel = (new Model)
            ->setId($model['id'])
            ->setName($modelName)
            ->setBrand($modelBrand)
            ->setPrice($modelPrice);

        $this->model = $objModel;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Order
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return Order
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }
}
