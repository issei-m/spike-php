<?php

namespace Issei\Spike\Model;

use Issei\Spike\Util\MoneyFactoryTrait;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class Charge
{
    use MoneyFactoryTrait;

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
     * @var Money
     */
    private $amount;

    /**
     * @var Card
     */
    private $source;

    /**
     * @var Boolean
     */
    private $refunded;

    /**
     * @var Money
     */
    private $amountRefunded;

    /**
     * @var array
     */
    private $refunds = [];

    /**
     * @var Dispute
     */
    private $dispute;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return $this->id;
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
     * @return self
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param  Card $source
     * @return self
     */
    public function setSource($source)
    {
        $this->source = $source;

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
     * @return Money
     */
    public function getAmountRefunded()
    {
        return $this->amountRefunded;
    }

    /**
     * @param  Money|float $amountRefunded
     * @param  string|null $currency
     * @return self
     */
    public function setAmountRefunded($amountRefunded, $currency = null)
    {
        $this->amountRefunded = $this->createMoney($amountRefunded, $currency);

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

    /**
     * @param  Dispute $dispute
     * @return self
     */
    public function setDispute($dispute)
    {
        $this->dispute = $dispute;

        return $this;
    }

    /**
     * @return Dispute
     */
    public function getDispute()
    {
        return $this->dispute;
    }
}
