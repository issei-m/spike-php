<?php

namespace Issei\Spike\Tests;

use Issei\Spike\ChargeRequest;
use Issei\Spike\Model\Money;
use Issei\Spike\Model\Product;

class ChargeRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testCardAccessors()
    {
        $request = new ChargeRequest();

        $request->setCard('_card_');
        $this->assertEquals('_card_', $request->getCard());
    }

    public function testAmountAccessors()
    {
        $request = new ChargeRequest();

        $request->setAmount(new Money(5000.0, 'JPY'));
        $this->assertEquals(new Money(5000.0, 'JPY'), $request->getAmount());

        $request->setAmount(300.50, 'USD');
        $this->assertEquals(new Money(300.50, 'USD'), $request->getAmount());
    }

    public function testProductsAccessors()
    {
        $request = new ChargeRequest();

        $request
            ->addProduct($productA = new Product('product-a-id'))
            ->addProduct($productB = new Product('product-b-id'))
        ;
        $this->assertCount(2, $request->getProducts());
        $this->assertSame($productA, $request->getProducts()[0]);
        $this->assertSame($productB, $request->getProducts()[1]);
    }
}
