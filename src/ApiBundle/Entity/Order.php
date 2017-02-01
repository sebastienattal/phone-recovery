<?php

namespace ApiBundle\Entity;

/**
 * Entity for orders
 */
class Order
{
    const DATETIME_FORMAT = 'Y-m-d H:i:s';

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
     * @param string $created
     * @return Order
     * @throws InvalidArgumentException
     */
    public function setCreated($created)
    {
        if (false === \DateTime::createFromFormat(self::DATETIME_FORMAT, $created)) {
            throw new \InvalidArgumentException(sprintf(
                'The date "%s" must be formatted to "%s"',
                $created, self::DATETIME_FORMAT
            ));
        }

        $this->created = new \DateTime($created);

        return $this;
    }
}
