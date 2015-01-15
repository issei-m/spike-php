<?php

namespace Issei\Spike;

use Issei\Spike\Model\Money;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
trait MoneyFactoryTrait
{
    /**
     * @param  Money|float $amount
     * @param  string|null $currency
     * @return self
     */
    private function createMoney($amount, $currency = null)
    {
        if ($amount instanceof Money) {
            return $amount;
        }

        return new Money($amount, $currency);
    }
}
