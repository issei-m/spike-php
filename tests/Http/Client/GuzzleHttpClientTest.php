<?php

namespace Spike\Tests\Http\Client;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use Issei\Spike\Http\Client\GuzzleHttpClient;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Issei\Spike\Http\Response;

class GuzzleHttpClientTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $SUT;

    private static $params = [
        'auth'            => ['_secret_', ''],
        'connect_timeout' => 10,
        'timeout'         => 30,
        'verify'          => true,
    ];

    protected function setUp()
    {
        $this->client = $this->prophesize(ClientInterface::class);
        $this->SUT = new GuzzleHttpClient($this->client->reveal());
    }

    public function testGetRequest()
    {
        $rawResponse = $this->prophesize(ResponseInterface::class);
        $rawResponse->getStatusCode()->willReturn(200);
        $rawResponse->getBody()->willReturn('_body_');

        $this->client->request('GET', 'http://localhost/', self::$params)->willReturn($rawResponse);

        $response = $this->SUT->request('GET', 'http://localhost/', '_secret_');
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('_body_', $response->getBody());
    }

    public function testPostRequest()
    {
        $rawResponse = $this->prophesize(ResponseInterface::class);
        $rawResponse->getStatusCode()->willReturn(200);
        $rawResponse->getBody()->willReturn('_body_');

        $this->client->request('POST', 'http://localhost/', array_merge(self::$params, [
            'form_params' => ['foo' => 'bar'],
        ]))->willReturn($rawResponse);

        $response = $this->SUT->request('POST', 'http://localhost/', '_secret_', ['foo' => 'bar']);
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('_body_', $response->getBody());
    }

    /**
     * @test
     */
    public function it_should_return_Response_even_if_guzzle_throws_BadResponseException()
    {
        $rawResponse = $this->prophesize(ResponseInterface::class);
        $rawResponse->getStatusCode()->willReturn(403);
        $rawResponse->getBody()->willReturn('_body_');

        $exception = new BadResponseException('error_message', $this->prophesize(RequestInterface::class)->reveal(), $rawResponse->reveal());
        $this->client->request('GET', 'http://localhost/', self::$params)->willThrow($exception);

        $response = $this->SUT->request('GET', 'http://localhost/', '_secret_');
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(403, $response->getStatusCode());
        self::assertEquals('_body_', $response->getBody());
    }

    /**
     * @test
     * @expectedException        \Issei\Spike\Exception\Exception
     * @expectedExceptionMessage error_message
     */
    public function it_should_throw_Exception_if_guzzle_throws_RequestException()
    {
        $exception = new RequestException('error_message', $this->prophesize(RequestInterface::class)->reveal(), $this->prophesize(ResponseInterface::class)->reveal());
        $this->client->request('GET', 'http://localhost/', self::$params)->willThrow($exception);

        $this->SUT->request('GET', 'http://localhost/', '_secret_');
    }
}
