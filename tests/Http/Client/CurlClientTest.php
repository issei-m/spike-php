<?php

namespace Spike\Tests\Http\Client;

use Issei\Spike\Http\Client\CurlClient;

class CurlClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CurlClient
     */
    protected $SUT;

    protected function setUp()
    {
        $this->SUT = new CurlClient();
    }

    public function getUrlProvider()
    {
        return [
            ['http://httpbin.org/get'],
            ['https://httpbin.org/get'],
        ];
    }

    public function postUrlProvider()
    {
        return [
            ['http://httpbin.org/post'],
            ['https://httpbin.org/post'],
        ];
    }

    public function statusCodeProvider()
    {
        return [
            [200],
            [300],
            [400],
            [500],
        ];
    }

    public function invalidUrlProvider()
    {
        return [
            ['http://unresolvable-host/'],
            ['unsupported-protocol://localhost/'],
        ];
    }

    /**
     * @dataProvider getUrlProvider
     */
    public function testGetRequest($url)
    {
        $queryData = [
            'foo' => 'bar',
        ];

        $response = $this->SUT->request('GET', $url . '?' . http_build_query($queryData), '_secret_');
        $this->assertInstanceOf('Issei\Spike\Http\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Basic ' . base64_encode('_secret_:'), $data['headers']['Authorization']);
        $this->assertEquals($queryData, $data['args']);
    }

    /**
     * @dataProvider postUrlProvider
     */
    public function testPostRequest($url)
    {
        $formData = [
            'foo' => 'bar',
        ];

        $response = $this->SUT->request('POST', $url, '_secret_', $formData);
        $this->assertInstanceOf('Issei\Spike\Http\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Basic ' . base64_encode('_secret_:'), $data['headers']['Authorization']);
        $this->assertEquals($formData, $data['form']);
    }

    /**
     * @dataProvider statusCodeProvider
     */
    public function testStatusCode($statusCode)
    {
        $response = $this->SUT->request('GET', 'https://httpbin.org/status/' . $statusCode, '');
        $this->assertInstanceOf('Issei\Spike\Http\Response', $response);
        $this->assertEquals($statusCode, $response->getStatusCode());
    }

    /**
     * @dataProvider      invalidUrlProvider
     * @expectedException \Issei\Spike\Exception\Exception
     */
    public function testRequestWithInvalidUrl($url)
    {
        $this->SUT->request('GET', $url, '');
    }
}
