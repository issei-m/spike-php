<?php

namespace Issei\Spike\Converter;

use Issei\Spike\Exception\UnknownObjectException;
use Issei\Spike\Model\Factory\ObjectFactoryInterface;

/**
 * Recursively converts the JSON serialize retrieved from api into model object with related object factory.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class RecursiveObjectFactoryConverter implements ObjectConverterInterface
{
    /**
     * @var ObjectFactoryInterface[]
     */
    private $objectFactories = [];
    private $ignoreUnknownObject;

    public function __construct(array $objectFactories, $ignoreUnknownObject = true)
    {
        foreach ($objectFactories as $objectFactory) {
            if (!$objectFactory instanceof ObjectFactoryInterface) {
                throw new \InvalidArgumentException('$objectFactories must be containing only ObjectFactoryInterface.');
            }

            $this->objectFactories[$objectFactory->getName()] = $objectFactory;
        }

        $this->ignoreUnknownObject = $ignoreUnknownObject;
    }

    /**
     * {@inheritdoc}
     */
    public function convert(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->convert($value);
            }
        }

        if (isset($data['object'])) {
            $data = $this->createObject($data);
        }

        return $data;
    }

    private function createObject(array $data)
    {
        $name = $data['object'];

        if (isset($this->objectFactories[$name])) {
            $data = $this->objectFactories[$name]->create($data);
        } elseif (!$this->ignoreUnknownObject) {
            throw new UnknownObjectException($name);
        }

        return $data;
    }
}
