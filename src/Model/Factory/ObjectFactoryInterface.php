<?php

namespace Issei\Spike\Model\Factory;

/**
 * Creates a new model object by JSON serialize retrieved from api.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
interface ObjectFactoryInterface
{
    /**
     * Returns the object name.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns the created object.
     *
     * @param  array $data
     * @return object
     */
    public function create(array $data);
}
