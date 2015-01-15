<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\Charge;
use Issei\Spike\Model\Money;
use Issei\Spike\Model\Refund;

class ChargeTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessors()
    {
        $charge = new Charge('charge');

        $charge
            ->setCreated(new \DateTime('2015-01-01 10:00:00'))
            ->setPaid(true)
            ->setCaptured(true)
            ->setRefunded(true)
            ->addRefund($refund1 = new Refund())
            ->addRefund($refund2 = new Refund())
        ;
        $this->assertEquals('charge', $charge->getId());
        $this->assertEquals(new \DateTime('2015-01-01 10:00:00'), $charge->getCreated());
        $this->assertTrue($charge->isPaid());
        $this->assertTrue($charge->isCaptured());
        $this->assertTrue($charge->isRefunded());
        $this->assertCount(2, $charge->getRefunds());
        $this->assertSame($refund1, $charge->getRefunds()[0]);
        $this->assertSame($refund2, $charge->getRefunds()[1]);
    }

    public function testAmountAccessors()
    {
        $charge = new Charge('charge');

        $charge->setAmount(new Money(5000.0, 'JPY'));
        $this->assertEquals(new Money(5000.0, 'JPY'), $charge->getAmount());

        $charge->setAmount(300.50, 'USD');
        $this->assertEquals(new Money(300.50, 'USD'), $charge->getAmount());
    }

    public function testAmountRefundedAccessors()
    {
        $charge = new Charge('charge');

        $charge->setAmountRefunded(new Money(5000.0, 'JPY'));
        $this->assertEquals(new Money(5000.0, 'JPY'), $charge->getAmountRefunded());

        $charge->setAmountRefunded(300.50, 'USD');
        $this->assertEquals(new Money(300.50, 'USD'), $charge->getAmountRefunded());
    }
}
