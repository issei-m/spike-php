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
    private $refundFactory;

    /**
     * @var ChargeFactory
     */
    private $SUT;

    protected function setUp()
    {
        date_default_timezone_set('Asia/Tokyo');

        $this->refundFactory = $this->getMockBuilder('Issei\Spike\Model\Factory\RefundFactory')->disableOriginalConstructor()->getMock();
        $this->SUT = new ChargeFactory($this->refundFactory);
    }

    public function testCreate()
    {
        $created = new \DateTime('2015/01/01 10:00:00', new \DateTimeZone('UTC'));
        $json = [
            'id'              => 'charge-id',
            'created'         => $created->getTimestamp(),
            'paid'            => true,
            'captured'        => true,
            'amount'          => '5000.0',
            'currency'        => 'JPY',
            'refunded'        => true,
            'amount_refunded' => '5000.0',
            'refunds'         => [
                ['refund-a-data'],
                ['refund-b-data'],
            ],
        ];

        $refundA = new Refund();
        $refundB = new Refund();
        $this->refundFactory->expects($this->at(0))->method('create')->with(['refund-a-data'])->will($this->returnValue($refundA));
        $this->refundFactory->expects($this->at(1))->method('create')->with(['refund-b-data'])->will($this->returnValue($refundB));

        $charge = $this->SUT->create($json);
        $this->assertInstanceOf('Issei\Spike\Model\Charge', $charge);
        $this->assertEquals('charge-id', $charge->getId());
        $this->assertEquals($created, $charge->getCreated());
        $this->assertEquals('+0900', $charge->getCreated()->format('O'), 'default timezone is used by default');
        $this->assertEquals(new Money(5000.0, 'JPY'), $charge->getAmount());
        $this->assertTrue($charge->isPaid());
        $this->assertTrue($charge->isCaptured());
        $this->assertTrue($charge->isRefunded());
        $this->assertEquals(new Money(5000.0, 'JPY'), $charge->getAmountRefunded());
        $this->assertCount(2, $charge->getRefunds());
        $this->assertSame($refundA, $charge->getRefunds()[0]);
        $this->assertSame($refundB, $charge->getRefunds()[1]);
    }

    /**
     * @test
     */
    public function it_should_be_timezone_specifiable_for_created()
    {
        $this->SUT = new ChargeFactory($this->refundFactory, new \DateTimeZone('Asia/Singapore'));

        $created = new \DateTime('2015/01/01 10:00:00', new \DateTimeZone('UTC'));
        $json = [
            'id'              => 'charge-identifier',
            'created'         => $created->getTimestamp(),
            'paid'            => true,
            'captured'        => true,
            'amount'          => '5000.0',
            'currency'        => 'JPY',
            'refunded'        => true,
            'amount_refunded' => '5000.0',
            'refunds'         => []
        ];

        $refund = $this->SUT->create($json);
        $this->assertEquals('+0800', $refund->getCreated()->format('O'));
    }
}
