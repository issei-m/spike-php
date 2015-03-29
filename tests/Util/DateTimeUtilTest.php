<?php

namespace Issei\Spike\Tests\Util;

use Issei\Spike\Util\DateTimeUtil;

class DateTimeUtilTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \DateTime
     */
    private $timestamp;

    protected function setUp()
    {
        date_default_timezone_set('Asia/Tokyo');
        $this->timestamp = (new \DateTime('2015/01/01 10:00:00', new \DateTimeZone('UTC')));
    }

    public function testGeneral()
    {
        $util = new DateTimeUtil();
        $dateTime = $util->createDateTimeByUnixTime($this->timestamp->getTimestamp());

        $this->assertEquals($this->timestamp, $dateTime);
        $this->assertEquals('+0900', $dateTime->format('O'), 'default timezone is used by default');
    }

    public function testSpecifiedTimeZone()
    {
        $util = new DateTimeUtil(new \DateTimeZone('Asia/Singapore'));
        $dateTime = $util->createDateTimeByUnixTime($this->timestamp->getTimestamp());

        $this->assertEquals($this->timestamp, $dateTime);
        $this->assertEquals('+0800', $dateTime->format('O'));
    }
}
