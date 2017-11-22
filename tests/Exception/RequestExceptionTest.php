<?php

namespace Issei\Spike\Tests\Exception;

use Issei\Spike\Exception\RequestException;
use PHPUnit\Framework\TestCase;

class RequestExceptionTest extends TestCase
{
    public function testConstructor()
    {
        $exception = new RequestException(400, [
            'error' => [
                'type'    => 'invalid_request_error',
                'message' => 'Charge is invalid.',
            ],
        ]);
        $this->assertEquals(400, $exception->getCode());
        $this->assertEquals('invalid_request_error', $exception->getType());
        $this->assertEquals('Charge is invalid.', $exception->getMessage());
    }
}
