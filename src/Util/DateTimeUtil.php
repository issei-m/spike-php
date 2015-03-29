<?php

namespace Issei\Spike\Util;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class DateTimeUtil
{
    /**
     * @var \DateTimeZone
     */
    private $specifiedTimeZone;

    public function __construct(\DateTimeZone $specifiedTimeZone = null)
    {
        $this->specifiedTimeZone = $specifiedTimeZone ?: new \DateTimeZone(date_default_timezone_get());
    }

    /**
     * Returns the created DateTime object specified the timezone.
     *
     * @param  $unixTime
     * @return \DateTime
     */
    public function createDateTimeByUnixTime($unixTime)
    {
        $dateTime = new \DateTime('@' . $unixTime);
        $dateTime->setTimezone($this->specifiedTimeZone);

        return $dateTime;
    }
}
