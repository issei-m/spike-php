<?php

namespace Issei\Spike\Exception;

use Issei\Spike\Exception;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class ApiErrorException extends Exception
{
    /**
     * @var string
     */
    private $type;

    public function __construct($code, $type, $message)
    {
        $this->type = $type;
        parent::__construct($message, $code);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
