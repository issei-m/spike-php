<?php

namespace Issei\Spike\Tests;

use Issei\Spike\ChargeRequest;
use Issei\Spike\Model\Money;
use Issei\Spike\Model\Product;
use Issei\Spike\Model\Token;

class ChargeRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testCardAccessors()
    {
        $request = new ChargeRequest();

        $token = new Token('card-a');
        $request->setCard($token);
        $this->assertEquals('card-a', $request->getCard());

        $request->setCard('card-b');
        $token = $request->getCard();
        $this->assertInstanceOf('Issei\Spike\Model\Token', $token, '$card is allowed to be a string.');
        $this->assertEquals('card-b', $token->getId(), '$card is allowed to be a string.');
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage $card must be an instance of Issei\Spike\Model\Token or a string.
     */
    public function setCard_should_throw_an_InvalidArgumentException_if_given_value_is_neither_Token_instance_nor_string()
    {
        $request = new ChargeRequest();

        $request->setCard(null);
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
