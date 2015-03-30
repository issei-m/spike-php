<?php

namespace Issei\Spike\Model;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class ObjectList implements \Countable, \ArrayAccess, \IteratorAggregate
{
    /**
     * @var array
     */
    private $objects;

    /**
     * @var Boolean
     */
    private $hasMore;

    public function __construct(array $objects, $hasMore)
    {
        $this->objects = $objects;
        $this->hasMore = $hasMore;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->objects);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->objects);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->objects[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return isset($this->objects[$offset]) ? $this->objects[$offset] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        throw new \BadMethodCallException('Issei\Spike\Model\ObjectList cannot be set any elements.');
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        throw new \BadMethodCallException('Issei\Spike\Model\ObjectList cannot be unset the elements.');
    }

    /**
     * Returns the first object.
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->objects) ?: null;
    }

    /**
     * Returns the last object.
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->objects) ?: null;
    }

    /**
     * @return Boolean
     */
    public function hasMore()
    {
        return $this->hasMore;
    }
}
