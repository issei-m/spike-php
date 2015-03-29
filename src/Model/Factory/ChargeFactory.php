<?php

namespace Issei\Spike\Model\Factory;

use Issei\Spike\Model\Charge;
use Issei\Spike\Model\Money;

/**
 * Creates a new charge object.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class ChargeFactory implements ObjectFactoryInterface
{
    use DateTimeUtilAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'charge';
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $charge = new Charge($data['id']);
        $charge
            ->setCreated($this->dateTimeUtil->createDateTimeByUnixTime($data['created']))
            ->setPaid($data['paid'])
            ->setCaptured($data['captured'])
            ->setAmount(new Money(floatval($data['amount']), $data['currency']))
            ->setRefunded($data['refunded'])
            ->setAmountRefunded(new Money(floatval($data['amount_refunded']), $data['currency']))
        ;

        foreach ($data['refunds'] as $refund) {
            $charge->addRefund($refund);
        }

        return $charge;
    }
}
