<?php

namespace Issei\Spike\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface as GuzzleHttpClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use Issei\Spike\Exception;
use Issei\Spike\Http\ClientInterface;
use Issei\Spike\Http\Response;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class GuzzleHttpClient implements ClientInterface
{
    /**
     * @var GuzzleHttpClientInterface
     */
    private $client;

    public function __construct(GuzzleHttpClientInterface $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * {@inheritdoc}
     */
    public function request($method, $url, $secret, array $params = [])
    {
        $options = [
            'auth'            => [$secret, ''],
            'connect_timeout' => 10,
            'timeout'         => 30,
            'verify'          => true,
        ];

        if ('GET' !== $method) {
            $options['body'] = $params;
        }

        $request = $this->client->createRequest($method, $url, $options);

        try {
            $rawResponse = $this->client->send($request);
        } catch (RequestException $e) {
            $rawResponse = $this->handleException($e);
        }

        return new Response($rawResponse->getStatusCode(), $rawResponse->getBody());
    }

    private function handleException(RequestException $exception)
    {
        if ($exception instanceof BadResponseException) {
            return $exception->getResponse();
        }

        throw new Exception($exception->getMessage(), $exception->getCode());
    }
}
