<?php

namespace Issei\Spike\Model\Factory;

use Issei\Spike\Model\Refund;

/**
 * Creates a new refund object with json that retrieved from api.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class RefundFactory
{
    use TimeZoneSpecifiableTrait;

    public function __construct(\DateTimeZone $specifiedTimeZone = null)
    {
        $this->specifiedTimeZone = $specifiedTimeZone;
    }

    /**
     * Returns a created refund object.
     *
     * @param  array $json
     * @return Refund
     */
    public function create(array $json)
    {
        $refund = new Refund();
        $refund
            ->setCreated($this->createDateTimeByUnixTime($json['created']))
            ->setAmount(floatval($json['amount']))
            ->setCurrency($json['currency'])
        ;

        return $refund;
    }
}
