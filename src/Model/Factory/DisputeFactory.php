<?php

namespace Issei\Spike\Model\Factory;

use Issei\Spike\Model\Dispute;
use Issei\Spike\Model\Money;

/**
 * Creates a new dispute object.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class DisputeFactory implements ObjectFactoryInterface
{
    use DateTimeUtilAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dispute';
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $dispute = new Dispute();
        $dispute
            ->setChargeId($data['charge'])
            ->setCreated($this->dateTimeUtil->createDateTimeByUnixTime($data['created']))
            ->setAmount(new Money(floatval($data['amount']), $data['currency']));

        return $dispute;
    }
}
