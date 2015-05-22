<?php

namespace Issei\Spike\Tests;

use Issei\Spike\ChargeRequest;
use Issei\Spike\Model\Money;
use Issei\Spike\Model\Product;
use Issei\Spike\Model\Token;

class ChargeRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testTokenAccessors()
    {
        $request = new ChargeRequest();

        $token = new Token('card-a');
        $request->setToken($token);
        $this->assertEquals('card-a', $request->getToken());

        $request->setToken('card-b');
        $token = $request->getToken();
        $this->assertInstanceOf('Issei\Spike\Model\Token', $token, '$card is allowed to be a string.');
        $this->assertEquals('card-b', $token->getId(), '$card is allowed to be a string.');
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage $card must be an instance of Issei\Spike\Model\Token or a string.
     */
    public function setToken_should_throw_an_InvalidArgumentException_if_given_value_is_neither_Token_instance_nor_string()
    {
        $request = new ChargeRequest();

        $request->setToken(null);
    }

    public function testAmountAccessors()
    {
        $request = new ChargeRequest();

        $request->setAmount(new Money(5000.0, 'JPY'));
        $this->assertEquals(new Money(5000.0, 'JPY'), $request->getAmount());

        $request->setAmount(300.50, 'USD');
        $this->assertEquals(new Money(300.50, 'USD'), $request->getAmount());
    }

    public function testOtherAccessors()
    {
        $request = new ChargeRequest();
        $this->assertTrue($request->isCapture());
        $this->assertSame([], $request->getProducts());

        $request
            ->setCapture(false)
            ->addProduct($productA = new Product('product-a-id'))
            ->addProduct($productB = new Product('product-b-id'))
        ;
        $this->assertFalse($request->isCapture());
        $this->assertCount(2, $request->getProducts());
        $this->assertSame($productA, $request->getProducts()[0]);
        $this->assertSame($productB, $request->getProducts()[1]);
    }
}
