<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\Dispute;
use Issei\Spike\Model\Money;

class DisputeTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessors()
    {
        $dispute = new Dispute();

        $dispute
            ->setChargeId('charge')
            ->setCreated(new \DateTime('2015-01-01 10:00:00'));
        $this->assertEquals('charge', $dispute->getChargeId());
        $this->assertEquals(new \DateTime('2015-01-01 10:00:00'), $dispute->getCreated());
    }

    public function testAmountAccessors()
    {
        $dispute = new Dispute();

        $dispute->setAmount(new Money(5000.0, 'JPY'));
        $this->assertEquals(new Money(5000.0, 'JPY'), $dispute->getAmount());

        $dispute->setAmount(300.50, 'USD');
        $this->assertEquals(new Money(300.50, 'USD'), $dispute->getAmount());
    }
}
