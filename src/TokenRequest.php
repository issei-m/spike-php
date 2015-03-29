<?php

namespace Issei\Spike;

/**
 * The request context for retrieving a new token.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class TokenRequest
{
    /**
     * @var string
     */
    private $cardNumber;

    /**
     * @var integer
     */
    private $expirationYear;

    /**
     * @var integer
     */
    private $expirationMonth;

    /**
     * @var string
     */
    private $holderName;

    /**
     * @var string
     */
    private $securityCode;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param  string $cardNumber
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setCardNumber($cardNumber)
    {
        if (!preg_match('/^[0-9]+$/', $cardNumber = str_replace('-', '', $cardNumber))) {
            throw new \InvalidArgumentException('The card number must be numerical.');
        }

        $this->cardNumber = $cardNumber;
        
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

    /**
     * @return string
     */
    public function getSecurityCode()
    {
        return $this->securityCode;
    }

    /**
     * @param  string $securityCode
     * @return self
     */
    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;

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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param  string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}
