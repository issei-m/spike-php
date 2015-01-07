<?php

namespace Issei\Spike;

use Issei\Spike\Model\Product;

/**
 * The request context for creating a new charge.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class ChargeRequest
{
    /**
     * @var string
     */
    private $currency;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $card;

    /**
     * @var Product[]
     */
    private $products = [];

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param  string $currency
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

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
     * @param  float $amount
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param  string $card
     * @return self
     */
    public function setCard($card)
    {
        $this->card = $card;

        return $this;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param  Product $product
     * @return self
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }
}
