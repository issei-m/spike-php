<?php

namespace Issei\Spike\Tests\Model;

use Issei\Spike\Model\ObjectList;

class ObjectListTest extends \PHPUnit_Framework_TestCase
{
    public function testGeneral()
    {
        $list = new ObjectList([], false);
        $this->assertFalse($list->hasMore());
        $this->assertCount(0, $list);
        $this->assertFalse(isset($list[0]));
        $this->assertNull($list[0]);
        $this->assertNull($list->first());
        $this->assertNull($list->last());
        $this->assertSame([], iterator_to_array($list->getIterator()));

        $objects = [$objectA = new \stdClass(), $objectB = new \stdClass()];
        $list = new ObjectList($objects, true);
        $this->assertTrue($list->hasMore());
        $this->assertCount(2, $list);
        $this->assertTrue(isset($list[0]));
        $this->assertTrue(isset($list[1]));
        $this->assertSame($objectA, $list[0]);
        $this->assertSame($objectB, $list[1]);
        $this->assertSame($objectA, $list->first());
        $this->assertSame($objectB, $list->last());
        $this->assertSame($objects, iterator_to_array($list->getIterator()));
    }

    /**
     * @test
     *
     * @expectedException        \BadMethodCallException
     * @expectedExceptionMessage Issei\Spike\Model\ObjectList cannot be set any elements.
     */
    public function it_should_be_unable_to_set_any_values()
    {
        $list = new ObjectList([], true);
        $list[0] = new \stdClass();
    }

    /**
     * @test
     *
     * @expectedException        \BadMethodCallException
     * @expectedExceptionMessage Issei\Spike\Model\ObjectList cannot be unset the elements.
     */
    public function it_should_be_unable_to_unset_any_values()
    {
        $list = new ObjectList([new \stdClass()], true);
        unset($list[0]);
    }
}
