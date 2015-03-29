<?php

namespace Issei\Spike\Converter;

/**
 * Converts the JSON serialize retrieved from api into the model object.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
interface ObjectConverterInterface
{
    /**
     * Returns the converted object.
     *
     * @param  array $data
     * @return mixed
     */
    public function convert(array $data);
}
