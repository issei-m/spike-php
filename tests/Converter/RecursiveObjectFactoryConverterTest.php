<?php

namespace Issei\Spike\Tests\Converter;

use Issei\Spike\Converter\RecursiveObjectFactoryConverter;
use Issei\Spike\Model\Factory\ObjectFactoryInterface;

class ConcreteFactoryA implements ObjectFactoryInterface
{
    protected static $invokedCount = 0;

    public function getName()
    {
        return 'foo';
    }

    public function create(array $data)
    {
        $data['_invoked'] = ++static::$invokedCount;

        return $data;
    }
}

class ConcreteFactoryB extends ConcreteFactoryA
{
    public function getName()
    {
        return 'bar';
    }
}

class RecursiveObjectFactoryConverterTest extends \PHPUnit_Framework_TestCase
{
    private static $testData = [
        [
            'object' => 'foo',
            'parent' => null,
            'bars' => [],
        ],
        [
            'object' => 'foo',
            'parent' => [
                'object' => 'foo',
                'parent' => null,
                'bars' => [
                    [
                        'object' => 'bar',
                        'unknown' => null,
                    ],
                ],
            ],
            'bars' => [
                [
                    'object' => 'bar',
                    'unknown' => [
                        'object' => 'unknown',
                    ],
                ],
            ],
        ],
    ];

    public function testConvert()
    {
        $converter = new RecursiveObjectFactoryConverter([ new ConcreteFactoryA(), new ConcreteFactoryB(), ]);

        $this->assertEquals([
            [
                'object' => 'foo',
                'parent' => null,
                'bars' => [],
                '_invoked' => 1,
            ],
            [
                'object' => 'foo',
                'parent' => [
                    'object' => 'foo',
                    'parent' => null,
                    'bars' => [
                        [
                            'object' => 'bar',
                            'unknown' => null,
                            '_invoked' => 2,
                        ],
                    ],
                    '_invoked' => 3,
                ],
                'bars' => [
                    [
                        'object' => 'bar',
                        'unknown' => [
                            'object' => 'unknown',
                        ],
                        '_invoked' => 4,
                    ],
                ],
                '_invoked' => 5,
            ],
        ], $converter->convert(self::$testData));
    }

    /**
     * @test
     *
     * @expectedException        \Issei\Spike\Exception\UnknownObjectException
     * @expectedExceptionMessage Detected unknown object "unknown".
     */
    public function convert_should_throw_an_UnknownObjectException_if_detected_unknown_object_and_ignoreUnknownObject_is_FALSE()
    {
        $converter = new RecursiveObjectFactoryConverter([ new ConcreteFactoryA(), new ConcreteFactoryB(), ], false);
        $converter->convert(static::$testData);
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage $objectFactories must be containing only ObjectFactoryInterface.
     */
    public function it_should_throw_an_InvalidArgumentException_if_array_containing_non_ObjectConverterInterface_is_passed()
    {
        new RecursiveObjectFactoryConverter([ new \stdClass(), ]);
    }
}
