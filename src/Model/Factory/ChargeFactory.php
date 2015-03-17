<?php

namespace Issei\Spike\Model\Factory;

use Issei\Spike\Model\Charge;
use Issei\Spike\Model\Money;

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
        $this->specifiedTimeZone = $specifiedTimeZone ?: new \DateTimeZone(date_default_timezone_get());
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
            ->setAmount(new Money(floatval($json['amount']), $json['currency']))
            ->setRefunded($json['refunded'])
            ->setAmountRefunded(new Money(floatval($json['amount_refunded']), $json['currency']))
        ;

        foreach ($json['refunds'] as $refundJson) {
            $charge->addRefund($this->refundFactory->create($refundJson));
        }

        return $charge;
    }
}
