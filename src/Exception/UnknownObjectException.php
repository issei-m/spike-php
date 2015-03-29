<?php

namespace Issei\Spike\Exception;

/**
 * Indicates detected unknown object during converting object process.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class UnknownObjectException extends Exception
{
    public function __construct($unknownObjectName)
    {
        parent::__construct(sprintf('Detected unknown object "%s".', $unknownObjectName));
    }
}
