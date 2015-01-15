<?php

namespace Issei\Spike;

use Issei\Spike\Model\Money;
use Issei\Spike\Model\Product;

/**
 * The request context for creating a new charge.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class ChargeRequest
{
    use MoneyFactoryTrait;

    /**
     * @var Money
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
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param  Money|float $amount
     * @param  string|null $currency
     * @return self
     */
    public function setAmount($amount, $currency = null)
    {
        $this->amount = $this->createMoney($amount, $currency);

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
