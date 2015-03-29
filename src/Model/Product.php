<?php

namespace Issei\Spike\Model;

use Issei\Spike\Util\MoneyFactoryTrait;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class Product implements \JsonSerializable
{
    use MoneyFactoryTrait;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $language;

    /**
     * @var Money
     */
    private $price;

    /**
     * @var integer
     */
    private $count;

    /**
     * @var integer
     */
    private $stock;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'language'    => $this->language,
            'price'       => $this->price ? $this->price->getAmount() : null,
            'currency'    => $this->price ? $this->price->getCurrency() : null,
            'count'       => $this->count,
            'stock'       => $this->stock,
        ];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param  string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param  string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param  string $language
     * @return self
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return Money
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param  Money|float $price
     * @param  string|null $currency
     * @return self
     */
    public function setPrice($price, $currency = null)
    {
        $this->price = $this->createMoney($price, $currency);

        return $this;
    }

    /**
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param  integer $count
     * @return self
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param  integer $stock
     * @return self
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }
}
