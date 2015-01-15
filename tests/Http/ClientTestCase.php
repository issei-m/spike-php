<?php

namespace Issei\Spike\Tests\Http;

use Issei\Spike\Http\ClientInterface;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class ClientTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientInterface
     */
    protected $SUT;

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
            [400],
            [500],
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
     * @expectedException \Issei\Spike\Exception
     */
    public function testRequestWithInvalidUrl()
    {
        $this->SUT->request('GET', 'ttp://localhost/', '', []);
    }
}
