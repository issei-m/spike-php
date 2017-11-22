<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\Card;
use Issei\Spike\Model\Charge;
use Issei\Spike\Model\Dispute;
use Issei\Spike\Model\Money;
use Issei\Spike\Model\Refund;
use PHPUnit\Framework\TestCase;

class ChargeTest extends TestCase
{
    public function testToString()
    {
        $token = new Charge('_charge_');
        $this->assertEquals('_charge_', $token);
    }

    public function testAccessors()
    {
        $charge = new Charge('charge');

        $charge
            ->setCreated(new \DateTime('2015-01-01 10:00:00'))
            ->setPaid(true)
            ->setCaptured(true)
            ->setSource($card = new Card())
            ->setRefunded(true)
            ->addRefund($refund1 = new Refund())
            ->addRefund($refund2 = new Refund())
            ->setDispute($dispute = new Dispute())
        ;
        $this->assertEquals('charge', $charge->getId());
        $this->assertEquals(new \DateTime('2015-01-01 10:00:00'), $charge->getCreated());
        $this->assertTrue($charge->isPaid());
        $this->assertTrue($charge->isCaptured());
        $this->assertSame($card, $charge->getSource());
        $this->assertTrue($charge->isRefunded());
        $this->assertCount(2, $charge->getRefunds());
        $this->assertSame($refund1, $charge->getRefunds()[0]);
        $this->assertSame($refund2, $charge->getRefunds()[1]);
        $this->assertSame($dispute, $charge->getDispute());

        $charge
            ->setSource(null)
            ->setDispute(null);
        $this->assertNull($charge->getSource(), 'source can be a null');
        $this->assertNull($charge->getDispute(), 'dispute can be a null');
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
