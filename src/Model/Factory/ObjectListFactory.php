<?php

namespace Issei\Spike\Model\Factory;

use Issei\Spike\Model\ObjectList;

/**
 * Creates a new object list object.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class ObjectListFactory implements ObjectFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'list';
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        return new ObjectList($data['data'], $data['has_more']);
    }
}
