<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\Money;

class MoneyTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessors()
    {
        $money = new Money(1000.0, 'JPY');
        $this->assertSame(1000.0, $money->getAmount());
        $this->assertEquals('JPY', $money->getCurrency());

        $money = new Money(100.50, 'USD');
        $this->assertSame(100.50, $money->getAmount());
        $this->assertEquals('USD', $money->getCurrency());
    }
}
