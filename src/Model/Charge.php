<?php

namespace Issei\Spike\Model;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class Charge
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var Boolean
     */
    private $paid;

    /**
     * @var Boolean
     */
    private $captured;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var Boolean
     */
    private $refunded;

    /**
     * @var float
     */
    private $amountRefunded;

    /**
     * @var array
     */
    private $refunds = [];

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
     * @return boolean
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @param  Boolean $paid
     * @return self
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCaptured()
    {
        return $this->captured;
    }

    /**
     * @param  Boolean $captured
     * @return self
     */
    public function setCaptured($captured)
    {
        $this->captured = $captured;

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
     * @return boolean
     */
    public function isRefunded()
    {
        return $this->refunded;
    }

    /**
     * @param  Boolean $refunded
     * @return self
     */
    public function setRefunded($refunded)
    {
        $this->refunded = $refunded;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmountRefunded()
    {
        return $this->amountRefunded;
    }

    /**
     * @param  float $amountRefunded
     * @return self
     */
    public function setAmountRefunded($amountRefunded)
    {
        $this->amountRefunded = $amountRefunded;

        return $this;
    }

    /**
     * @return array
     */
    public function getRefunds()
    {
        return $this->refunds;
    }

    /**
     * @param  Refund $refund
     * @return self
     */
    public function addRefund(Refund $refund)
    {
        $this->refunds[] = $refund;

        return $this;
    }
}
