<?php

namespace Issei\Spike\Tests\Model\Factory;

use Issei\Spike\Model\Card;
use Issei\Spike\Model\Dispute;
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

    /**
     * @var \DateTime
     */
    private $dateTime;

    protected function setUp()
    {
        $this->dateTimeUtil = $this->getMockBuilder('Issei\Spike\Util\DateTimeUtil')->disableOriginalConstructor()->getMock();
        $this->SUT = new ChargeFactory($this->dateTimeUtil);

        $this->dateTime = new \DateTime('2015/01/01 10:00:00', new \DateTimeZone('UTC'));
        $this->dateTimeUtil->expects($this->any())->method('createDateTimeByUnixTime')->with(123)->will($this->returnValue($this->dateTime));
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
            'source' => new Card(),
            'refunds'         => [
                new Refund(),
                new Refund(),
            ],
            'dispute' => new Dispute(),
        ];

        $charge = $this->SUT->create($data);
        $this->assertInstanceOf('Issei\Spike\Model\Charge', $charge);
        $this->assertEquals('charge-id', $charge->getId());
        $this->assertSame($this->dateTime, $charge->getCreated());
        $this->assertEquals(new Money(5000.0, 'JPY'), $charge->getAmount());
        $this->assertTrue($charge->isPaid());
        $this->assertTrue($charge->isCaptured());
        $this->assertEquals(new Money(5000.0, 'JPY'), $charge->getAmountRefunded());
        $this->assertSame($data['source'], $charge->getSource());
        $this->assertTrue($charge->isRefunded());
        $this->assertCount(2, $charge->getRefunds());
        $this->assertSame($data['refunds'][0], $charge->getRefunds()[0]);
        $this->assertSame($data['refunds'][1], $charge->getRefunds()[1]);
        $this->assertSame($data['dispute'], $charge->getDispute());
    }

    /**
     * @test
     */
    public function it_should_allow_to_be_passed_empty_array_for_source()
    {
        $data = [
            'id' => 'charge-id',
            'created' => 123,
            'paid' => true,
            'captured' => true,
            'amount' => '5000.0',
            'currency' => 'JPY',
            'refunded' => true,
            'amount_refunded' => '5000.0',
            'source' => [],
            'refunds' => [],
            'dispute' => null,
        ];

        $charge = $this->SUT->create($data);
        $this->assertNull($charge->getSource());
    }
}
