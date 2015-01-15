<?php

namespace Issei\Spike\Tests\Model\Factory;

use Issei\Spike\Model\Factory\RefundFactory;
use Issei\Spike\Model\Money;

class RefundFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RefundFactory
     */
    private $SUT;

    protected function setUp()
    {
        $this->SUT = new RefundFactory();
    }

    public function testCreate()
    {
        $created = new \DateTime('2015/01/01 10:00:00', new \DateTimeZone('UTC'));
        $json = [
            'created'  => $created->getTimestamp(),
            'amount'   => '5000.0',
            'currency' => 'JPY',
        ];

        $refund = $this->SUT->create($json);
        $this->assertInstanceOf('Issei\Spike\Model\Refund', $refund);
        $this->assertEquals($created, $refund->getCreated());
        $this->assertEquals('+00:00', $refund->getCreated()->getTimezone()->getName());
        $this->assertEquals(new Money(5000.0, 'JPY'), $refund->getAmount());
    }

    /**
     * @test
     */
    public function it_should_be_timezone_specifiable_for_created()
    {
        $this->SUT = new RefundFactory(new \DateTimeZone('Asia/Tokyo'));

        $created = new \DateTime('2015/01/01 10:00:00', new \DateTimeZone('UTC'));
        $json = [
            'created'  => $created->getTimestamp(),
            'amount'   => '5000.0',
            'currency' => 'JPY',
        ];

        $refund = $this->SUT->create($json);
        $this->assertEquals('Asia/Tokyo', $refund->getCreated()->getTimezone()->getName());
    }
}
