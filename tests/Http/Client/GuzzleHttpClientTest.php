<?php

namespace Spike\Tests\Http\Client;

use GuzzleHttp\Client;
use Issei\Spike\Http\Client\GuzzleHttpClient;
use Issei\Spike\Tests\Http\ClientTestCase;

class GuzzleHttpClientTest extends ClientTestCase
{
    protected function setUp()
    {
        $this->SUT = new GuzzleHttpClient(new Client());
    }
}
