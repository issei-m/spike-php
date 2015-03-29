<?php

namespace Issei\Spike\Tests\Model\Factory;

use Issei\Spike\Model\Factory\ChargeFactory;
use Issei\Spike\Model\Money;
use Issei\Spike\Model\Refund;

class ChargeFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $dateTimeUtil;

    /**
     * @var ChargeFactory
     */
    private $SUT;

    protected function setUp()
    {
        $this->dateTimeUtil = $this->getMockBuilder('Issei\Spike\Util\DateTimeUtil')->disableOriginalConstructor()->getMock();
        $this->SUT = new ChargeFactory($this->dateTimeUtil);
    }

    public function testGetName()
    {
        $this->assertEquals('charge', $this->SUT->getName());
    }

    public function testCreate()
    {
        $data = [
            'id'              => 'charge-id',
            'created'         => 123,
            'paid'            => true,
            'captured'        => true,
            'amount'          => '5000.0',
            'currency'        => 'JPY',
            'refunded'        => true,
            'amount_refunded' => '5000.0',
            'refunds'         => [
                new Refund(),
                new Refund(),
            ],
        ];

        $dateTime = new \DateTime('2015/01/01 10:00:00', new \DateTimeZone('UTC'));
        $this->dateTimeUtil->expects($this->once())->method('createDateTimeByUnixTime')->with(123)->will($this->returnValue($dateTime));

        $charge = $this->SUT->create($data);
        $this->assertInstanceOf('Issei\Spike\Model\Charge', $charge);
        $this->assertEquals('charge-id', $charge->getId());
        $this->assertSame($dateTime, $charge->getCreated());
        $this->assertEquals(new Money(5000.0, 'JPY'), $charge->getAmount());
        $this->assertTrue($charge->isPaid());
        $this->assertTrue($charge->isCaptured());
        $this->assertTrue($charge->isRefunded());
        $this->assertEquals(new Money(5000.0, 'JPY'), $charge->getAmountRefunded());
        $this->assertCount(2, $charge->getRefunds());
        $this->assertSame($data['refunds'][0], $charge->getRefunds()[0]);
        $this->assertSame($data['refunds'][1], $charge->getRefunds()[1]);
    }
}
