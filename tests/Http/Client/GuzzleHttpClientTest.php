<?php

namespace Spike\Tests\Http\Client;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use Issei\Spike\Http\Client\GuzzleHttpClient;

class GuzzleHttpClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $client;

    /**
     * @var GuzzleHttpClient
     */
    private $SUT;

    private static $params = [
        'auth'            => ['_secret_', ''],
        'connect_timeout' => 10,
        'timeout'         => 30,
        'verify'          => true,
    ];

    protected function setUp()
    {
        $this->client = $this->getMock('GuzzleHttp\ClientInterface');
        $this->SUT = new GuzzleHttpClient($this->client);
    }

    private function expect_that_client_will_be_called_createRequest_method_with($method, $url, $options)
    {
        $request = $this->getMock('GuzzleHttp\Message\RequestInterface');

        $this->client
            ->expects($this->once())
            ->method('createRequest')
            ->with($method, $url, $options)
            ->will($this->returnValue($request))
        ;

        return $request;
    }

    public function testGetRequest()
    {
        $request = $this->expect_that_client_will_be_called_createRequest_method_with('GET', 'http://localhost/', self::$params);

        $rawResponse = $this->getMock('GuzzleHttp\Message\ResponseInterface');

        $this->client
            ->expects($this->once())
            ->method('send')
            ->with($this->identicalTo($request))
            ->will($this->returnValue($rawResponse))
        ;

        $rawResponse->expects($this->once())->method('getStatusCode')->will($this->returnValue(200));
        $rawResponse->expects($this->once())->method('getBody')->will($this->returnValue('_body_'));

        $response = $this->SUT->request('GET', 'http://localhost/', '_secret_');
        $this->assertInstanceOf('Issei\Spike\Http\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('_body_', $response->getBody());
    }

    public function testPostRequest()
    {
        $request = $this->expect_that_client_will_be_called_createRequest_method_with('POST', 'http://localhost/', array_merge(self::$params, [
            'body'            => ['foo' => 'bar'],
        ]));

        $rawResponse = $this->getMock('GuzzleHttp\Message\ResponseInterface');

        $this->client
            ->expects($this->once())
            ->method('send')
            ->with($this->identicalTo($request))
            ->will($this->returnValue($rawResponse))
        ;

        $rawResponse->expects($this->once())->method('getStatusCode')->will($this->returnValue(200));
        $rawResponse->expects($this->once())->method('getBody')->will($this->returnValue('_body_'));

        $response = $this->SUT->request('POST', 'http://localhost/', '_secret_', ['foo' => 'bar']);
        $this->assertInstanceOf('Issei\Spike\Http\Response', $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('_body_', $response->getBody());
    }

    /**
     * @test
     */
    public function it_should_return_Response_even_if_guzzle_throws_BadResponseException()
    {
        $request = $this->expect_that_client_will_be_called_createRequest_method_with('GET', 'http://localhost/', self::$params);

        $rawResponse = $this->getMock('GuzzleHttp\Message\ResponseInterface');

        $this->client
            ->expects($this->once())
            ->method('send')
            ->with($this->identicalTo($request))
            ->will($this->throwException(new BadResponseException('', $request, $rawResponse)))
        ;

        $rawResponse->expects($this->once())->method('getStatusCode')->will($this->returnValue(400));
        $rawResponse->expects($this->once())->method('getBody')->will($this->returnValue('_body_'));

        $response = $this->SUT->request('GET', 'http://localhost/', '_secret_');
        $this->assertInstanceOf('Issei\Spike\Http\Response', $response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('_body_', $response->getBody());
    }

    /**
     * @test
     * @expectedException        \Issei\Spike\Exception
     * @expectedExceptionMessage error_message
     */
    public function it_should_throw_Exception_if_guzzle_throws_RequestException()
    {
        $request = $this->expect_that_client_will_be_called_createRequest_method_with('GET', 'http://localhost/', self::$params);

        $this->client
            ->expects($this->once())
            ->method('send')
            ->with($this->identicalTo($request))
            ->will($this->throwException(new RequestException('error_message', $request, $this->getMock('GuzzleHttp\Message\ResponseInterface'))))
        ;

        $this->SUT->request('GET', 'http://localhost/', '_secret_');
    }
}
