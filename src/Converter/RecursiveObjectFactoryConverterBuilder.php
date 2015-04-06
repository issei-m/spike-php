<?php

namespace Issei\Spike\Converter;

use Issei\Spike\Model\Factory\ChargeFactory;
use Issei\Spike\Model\Factory\CardFactory;
use Issei\Spike\Model\Factory\DisputeFactory;
use Issei\Spike\Model\Factory\ObjectListFactory;
use Issei\Spike\Model\Factory\RefundFactory;
use Issei\Spike\Model\Factory\TokenFactory;
use Issei\Spike\Util\DateTimeUtil;

/**
 * Builds a RecursiveObjectFactoryConverterBuilder.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 *
 * @codeCoverageIgnore
 */
final class RecursiveObjectFactoryConverterBuilder
{
    /**
     * @var \DateTimeZone
     */
    private $dateTimeZone;

    /**
     * @param \DateTimeZone $dateTimeZone
     */
    public function setDateTimeZone($dateTimeZone)
    {
        $this->dateTimeZone = $dateTimeZone;
    }

    public function getBuilder()
    {
        $dateTimeUtil = new DateTimeUtil($this->dateTimeZone);

        return new RecursiveObjectFactoryConverter([
            new ChargeFactory($dateTimeUtil),
            new RefundFactory($dateTimeUtil),
            new DisputeFactory($dateTimeUtil),
            new TokenFactory($dateTimeUtil),
            new CardFactory(),
            new ObjectListFactory(),
        ]);
    }
}
