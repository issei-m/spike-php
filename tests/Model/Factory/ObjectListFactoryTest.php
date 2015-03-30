<?php

namespace Issei\Spike\Tests\Model\Factory;

use Issei\Spike\Model\Factory\ObjectListFactory;

class ObjectListFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectListFactory
     */
    private $SUT;

    protected function setUp()
    {
        $this->SUT = new ObjectListFactory();
    }

    public function testGetName()
    {
        $this->assertEquals('list', $this->SUT->getName());
    }

    public function testCreate()
    {
        $data = [
            'data' => [
                $objectA = new \stdClass(),
                $objectB = new \stdClass(),
            ],
            'has_more' => true,
        ];

        $list = $this->SUT->create($data);
        $this->assertInstanceOf('Issei\Spike\Model\ObjectList', $list);
        $this->assertSame($data['data'], iterator_to_array($list->getIterator()));
        $this->assertTrue($list->hasMore());
    }
}
