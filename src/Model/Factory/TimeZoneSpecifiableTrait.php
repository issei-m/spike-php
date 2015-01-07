<?php

namespace Issei\Spike\Model\Factory;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
trait TimeZoneSpecifiableTrait
{
    /**
     * @var \DateTimeZone
     */
    private $specifiedTimeZone;

    private function createDateTimeByUnixTime($unixTime)
    {
        $dateTime = new \DateTime('@' . $unixTime);
        if ($this->specifiedTimeZone) {
            $dateTime->setTimezone($this->specifiedTimeZone);
        }

        return $dateTime;
    }
}
