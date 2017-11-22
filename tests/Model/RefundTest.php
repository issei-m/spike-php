<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\Money;
use Issei\Spike\Model\Refund;
use PHPUnit\Framework\TestCase;

class RefundTest extends TestCase
{
    public function testCreatedAccessors()
    {
        $refund = new Refund();

        $refund->setCreated(new \DateTime('2015-01-01 10:00:00'));
        $this->assertEquals(new \DateTime('2015-01-01 10:00:00'), $refund->getCreated());
    }

    public function testAmountAccessors()
    {
        $refund = new Refund();

        $refund->setAmount(new Money(5000.0, 'JPY'));
        $this->assertEquals(new Money(5000.0, 'JPY'), $refund->getAmount());

        $refund->setAmount(300.50, 'USD');
        $this->assertEquals(new Money(300.50, 'USD'), $refund->getAmount());
    }
}
