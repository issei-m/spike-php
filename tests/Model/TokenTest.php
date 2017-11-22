<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\Token;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
    public function testToString()
    {
        $token = new Token('_token_');
        $this->assertEquals('_token_', $token);
    }
}
