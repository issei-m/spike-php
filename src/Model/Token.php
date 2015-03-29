<?php

namespace Issei\Spike\Model;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class Token
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var Card
     */
    private $source;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param  \DateTime $created
     * @return self
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return Card
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param  Card $source
     * @return self
     */
    public function setSource(Card $source)
    {
        $this->source = $source;

        return $this;
    }
}
