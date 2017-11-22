<?php

namespace Issei\Spike\Tests;

use Issei\Spike\TokenRequest;
use PHPUnit\Framework\TestCase;

class TokenRequestTest extends TestCase
{
    public function testSetCardNumber()
    {
        $request = new TokenRequest();
        $request->setCardNumber('4444-3333-2222-1111');
        $this->assertEquals('4444333322221111', $request->getCardNumber(), 'dashes is removed');
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The card number must be numerical.
     */
    public function setCardNumber_should_throw_an_InvalidArgumentException_if_non_numerical_string()
    {
        $request = new TokenRequest();
        $request->setCardNumber('0xFF');
    }
}
