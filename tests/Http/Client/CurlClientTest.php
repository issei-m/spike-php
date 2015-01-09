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

    public function testGetRequest()
    {
        $response = $this->SUT->request('GET', 'http://httpbin.org/get', '_secret_');
        $this->assertInstanceOf('Issei\Spike\Http\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Basic ' . base64_encode('_secret_:'), $data['headers']['Authorization']);
    }

    public function testPostRequest()
    {
        $formData = [
            'foo' => 'bar',
        ];

        $response = $this->SUT->request('POST', 'http://httpbin.org/post', '_secret_', $formData);
        $this->assertInstanceOf('Issei\Spike\Http\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $this->assertEquals($formData, $data['form']);
        $this->assertEquals('Basic ' . base64_encode('_secret_:'), $data['headers']['Authorization']);

    }

    /**
     * @expectedException     \Issei\Spike\Exception
     * @expectedExceptionCode 1
     */
    public function testRequestWithInvalidUrl()
    {
        $this->SUT->request('GET', 'ttp://localhost/', '', []);
    }
}
