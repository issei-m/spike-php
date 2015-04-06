<?php

namespace Issei\Spike\Model;

use Issei\Spike\Util\MoneyFactoryTrait;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class Dispute
{
    use MoneyFactoryTrait;

    /**
     * @var string
     */
    private $chargeId;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var Money
     */
    private $amount;

    /**
     * @return string
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }

    /**
     * @param  string $chargeId
     * @return self
     */
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;

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
