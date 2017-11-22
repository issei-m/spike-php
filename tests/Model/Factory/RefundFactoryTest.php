<?php

namespace Issei\Spike\Tests\Model\Factory;

use Issei\Spike\Model\Factory\RefundFactory;
use Issei\Spike\Model\Money;
use PHPUnit\Framework\TestCase;

class RefundFactoryTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $dateTimeUtil;

    /**
     * @var RefundFactory
     */
    private $SUT;

    protected function setUp()
    {
        $this->dateTimeUtil = $this->getMockBuilder('Issei\Spike\Util\DateTimeUtil')->disableOriginalConstructor()->getMock();
        $this->SUT = new RefundFactory($this->dateTimeUtil);
    }

    public function testGetName()
    {
        $this->assertEquals('refund', $this->SUT->getName());
    }

    public function testCreate()
    {
        $json = [
            'created'  => 123,
            'amount'   => '5000.0',
            'currency' => 'JPY',
        ];

        $dateTime = new \DateTime('2015/01/01 10:00:00', new \DateTimeZone('UTC'));
        $this->dateTimeUtil->expects($this->once())->method('createDateTimeByUnixTime')->with(123)->will($this->returnValue($dateTime));

        $refund = $this->SUT->create($json);
        $this->assertInstanceOf('Issei\Spike\Model\Refund', $refund);
        $this->assertEquals($dateTime, $refund->getCreated());
        $this->assertEquals(new Money(5000.0, 'JPY'), $refund->getAmount());
    }
}
