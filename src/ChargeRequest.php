<?php

namespace Issei\Spike;

use Issei\Spike\Model\Money;
use Issei\Spike\Model\Product;
use Issei\Spike\Model\Token;
use Issei\Spike\Util\MoneyFactoryTrait;

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
     * @var Token
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
     * @return Token
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param  Token|string $card
     * @return self
     */
    public function setCard($card)
    {
        if (is_string($card)) {
            $card = new Token($card);
        } elseif (!$card instanceof Token) {
            throw new \InvalidArgumentException('$card must be an instance of Issei\Spike\Model\Token or a string.');
        }

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
