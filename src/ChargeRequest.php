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
     * @var Token
     */
    private $token;

    /**
     * @var Money
     */
    private $amount;

    /**
     * @var Boolean
     */
    private $capture = true;

    /**
     * @var Product[]
     */
    private $products = [];

    /**
     * @return Token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param  Token|string $card
     * @return self
     */
    public function setToken($card)
    {
        if (is_string($card)) {
            $card = new Token($card);
        } elseif (!$card instanceof Token) {
            throw new \InvalidArgumentException('$card must be an instance of Issei\Spike\Model\Token or a string.');
        }

        $this->token = $card;

        return $this;
    }

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
     * @return Boolean
     */
    public function isCapture()
    {
        return $this->capture;
    }

    /**
     * @param  Boolean $capture
     * @return self
     */
    public function setCapture($capture)
    {
        $this->capture = (bool) $capture;

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
