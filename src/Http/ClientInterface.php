<?php

namespace Issei\Spike\Http;

use Issei\Spike\Exception\Exception;

/**
 * Handles the api via HTTP.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
interface ClientInterface
{
    /**
     * Sends a request to api and returns its response.
     *
     * @param  string $method
     * @param  string $url
     * @param  string $secret
     * @param  array  $params
     *
     * @return Response
     *
     * @throws Exception
     */
    public function request($method, $url, $secret, array $params = []);
}
