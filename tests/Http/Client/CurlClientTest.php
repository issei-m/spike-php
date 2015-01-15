<?php

namespace Spike\Tests\Http\Client;

use Issei\Spike\Http\Client\CurlClient;
use Issei\Spike\Tests\Http\ClientTestCase;

class CurlClientTest extends ClientTestCase
{
    protected function setUp()
    {
        $this->SUT = new CurlClient();
    }
}
