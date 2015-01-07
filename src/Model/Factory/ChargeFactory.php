<?php

namespace Issei\Spike\Model\Factory;

use Issei\Spike\Model\Charge;

/**
 * Creates a new charge object with json that retrieved from api.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class ChargeFactory
{
    use TimeZoneSpecifiableTrait;

    /**
     * @var RefundFactory
     */
    private $refundFactory;

    public function __construct(RefundFactory $refundFactory, \DateTimeZone $specifiedTimeZone = null)
    {
        $this->refundFactory     = $refundFactory;
        $this->specifiedTimeZone = $specifiedTimeZone;
    }

    /**
     * Returns a created charge object.
     *
     * @param  array $json
     * @return Charge
     */
    public function create(array $json)
    {
        $charge = new Charge($json['id']);
        $charge
            ->setCreated($this->createDateTimeByUnixTime($json['created']))
            ->setPaid($json['paid'])
            ->setCaptured($json['captured'])
            ->setAmount(floatval($json['amount']))
            ->setCurrency($json['currency'])
            ->setRefunded($json['refunded'])
            ->setAmountRefunded(floatval($json['amount_refunded']))
        ;

        foreach ($json['refunds'] as $refundJson) {
            $charge->addRefund($this->refundFactory->create($refundJson));
        }

        return $charge;
    }
}
