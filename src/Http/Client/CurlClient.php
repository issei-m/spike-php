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
            CURLOPT_URL            => $url,
            CURLOPT_USERPWD        => $secret . ':',
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
        ];

        if ('GET' !== $method) {
            $options[CURLOPT_POST]       = true;
            $options[CURLOPT_POSTFIELDS] = $params;
        }

        $curl = curl_init();
        curl_setopt_array($curl, $options);

        $body = curl_exec($curl);

        if (false === $body) {
            $message = curl_error($curl);
            $code    = curl_errno($curl);

            throw new Exception($message, $code);
        }

        $response = new Response(curl_getinfo($curl)['http_code'], $body);

        curl_close($curl);

        return $response;
    }
}
