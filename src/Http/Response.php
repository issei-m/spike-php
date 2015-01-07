<?php

namespace Issei\Spike\Http;

/**
 * The pretty simple http response implementation.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class Response
{
    /**
     * @var integer
     */
    private $statusCode;

    /**
     * @var string
     */
    private $body;

    public function __construct($statusCode, $body)
    {
        $this->statusCode = $statusCode;
        $this->body       = $body;
    }

    /**
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}
