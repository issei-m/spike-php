<?php

namespace Issei\Spike\Model;

use Issei\Spike\MoneyFactoryTrait;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class Refund
{
    use MoneyFactoryTrait;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param  \DateTime $created
     * @return self
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

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
     * @var Money
     */
    private $amount;

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
}
