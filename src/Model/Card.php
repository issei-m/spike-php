<?php

namespace Issei\Spike\Model;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class Card
{
    /**
     * @var string
     */
    private $cardNumberLast4;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var integer
     */
    private $expirationMonth;

    /**
     * @var integer
     */
    private $expirationYear;

    /**
     * @var string
     */
    private $holderName;

    /**
     * @return string
     */
    public function getCardNumberLast4()
    {
        return $this->cardNumberLast4;
    }

    /**
     * @param  string $cardNumberLast4
     * @return self
     */
    public function setCardNumberLast4($cardNumberLast4)
    {
        $this->cardNumberLast4 = $cardNumberLast4;

        return $this;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param  string $brand
     * @return self
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return integer
     */
    public function getExpirationMonth()
    {
        return $this->expirationMonth;
    }

    /**
     * @param  integer $expirationMonth
     * @return self
     */
    public function setExpirationMonth($expirationMonth)
    {
        $this->expirationMonth = $expirationMonth;

        return $this;
    }

    /**
     * @return integer
     */
    public function getExpirationYear()
    {
        return $this->expirationYear;
    }

    /**
     * @param  integer $expirationYear
     * @return self
     */
    public function setExpirationYear($expirationYear)
    {
        $this->expirationYear = $expirationYear;

        return $this;
    }

    /**
     * @return string
     */
    public function getHolderName()
    {
        return $this->holderName;
    }

    /**
     * @param  string $holderName
     * @return self
     */
    public function setHolderName($holderName)
    {
        $this->holderName = $holderName;

        return $this;
    }
}
