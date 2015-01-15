<?php

namespace Issei\Spike\Http\Client;

use Issei\Spike\Exception;
use Issei\Spike\Http\ClientInterface;
use Issei\Spike\Http\Response;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class CurlClient implements ClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function request($method, $url, $secret, array $params = [])
    {
        $options = [
            CURLOPT_USERPWD        => $secret . ':',
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
        ];

        if ('GET' !== $method) {
            $options[CURLOPT_POST]       = true;
            $options[CURLOPT_POSTFIELDS] = $params;
        }

        $curl = curl_init($url);
        curl_setopt_array($curl, $options);

        return $this->requestByCurl($curl);
    }

    private function requestByCurl($curl)
    {
        $body = curl_exec($curl);

        if (false === $body) {
            $exception = new Exception(curl_error($curl), curl_errno($curl));
            curl_close($curl);

            throw $exception;
        }

        $response = new Response(curl_getinfo($curl, CURLINFO_HTTP_CODE), $body);
        curl_close($curl);

        return $response;
    }
}
