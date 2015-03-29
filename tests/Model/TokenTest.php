<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\Token;

class TokenTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $token = new Token('_token_');
        $this->assertEquals('_token_', $token);
    }
}
