<?php

namespace Spike\Tests\Http\Client;

use Issei\Spike\Http\Client\CurlClient;

class CurlClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CurlClient
     */
    private $SUT;

    protected function setUp()
    {
        $this->SUT = new CurlClient();
    }

    /**
     * @expectedException        \Issei\Spike\Exception
     * @expectedExceptionCode    1
     */
    public function testRequestWithInvalidUrl()
    {
        $this->SUT->request('GET', 'ttp://localhost/', '', []);
    }
}
