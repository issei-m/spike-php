<?php

namespace Issei\Spike\Tests\Model\Factory;

use Issei\Spike\Model\Factory\DisputeFactory;
use Issei\Spike\Model\Money;

class DisputeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $dateTimeUtil;

    /**
     * @var DisputeFactory
     */
    private $SUT;

    protected function setUp()
    {
        $this->dateTimeUtil = $this->getMockBuilder('Issei\Spike\Util\DateTimeUtil')->disableOriginalConstructor()->getMock();
        $this->SUT = new DisputeFactory($this->dateTimeUtil);
    }

    public function testGetName()
    {
        $this->assertEquals('dispute', $this->SUT->getName());
    }

    public function testCreate()
    {
        $json = [
            'charge' => 'charge',
            'created' => 1400220648,
            'amount' => 5000,
            'currency' => 'JPY',
        ];

        $dateTime = new \DateTime('2015/01/01 10:00:00', new \DateTimeZone('UTC'));
        $this->dateTimeUtil->expects($this->once())->method('createDateTimeByUnixTime')->with(1400220648)->will($this->returnValue($dateTime));

        $dispute = $this->SUT->create($json);
        $this->assertInstanceOf('Issei\Spike\Model\Dispute', $dispute);
        $this->assertEquals('charge', $dispute->getChargeId());
        $this->assertEquals($dateTime, $dispute->getCreated());
        $this->assertEquals(new Money(5000.0, 'JPY'), $dispute->getAmount());
    }
}
