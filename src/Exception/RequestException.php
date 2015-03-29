<?php

namespace Issei\Spike\Exception;

/**
 * Indicates error occurred at api (e.g. Authentication failed, Bad request, etc).
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class RequestException extends Exception
{
    /**
     * @var string
     */
    private $type;

    public function __construct($statusCode, array $data)
    {
        $this->type = $data['error']['type'];
        parent::__construct($data['error']['message'], $statusCode);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
