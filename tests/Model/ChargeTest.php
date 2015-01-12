<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\Charge;
use Issei\Spike\Model\Refund;

class ChargeTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessors()
    {
        $charge = new Charge('Charge.id');
        $charge
            ->setCreated(new \DateTime('2015-01-01 10:00:00'))
            ->setPaid(true)
            ->setCaptured(true)
            ->setAmount(5000.0)
            ->setCurrency('JPY')
            ->setRefunded(true)
            ->setAmountRefunded(5000.0)
            ->addRefund($refund1 = new Refund())
            ->addRefund($refund2 = new Refund())
        ;

        $this->assertEquals('Charge.id', $charge->getId());
        $this->assertEquals(new \DateTime('2015-01-01 10:00:00'), $charge->getCreated());
        $this->assertTrue($charge->isPaid());
        $this->assertTrue($charge->isCaptured());
        $this->assertSame(5000.0, $charge->getAmount());
        $this->assertEquals('JPY', $charge->getCurrency());
        $this->assertTrue($charge->isRefunded());
        $this->assertSame(5000.0, $charge->getAmountRefunded());
        $this->assertCount(2, $charge->getRefunds());
        $this->assertSame($refund1, $charge->getRefunds()[0]);
        $this->assertSame($refund2, $charge->getRefunds()[1]);
    }
}
