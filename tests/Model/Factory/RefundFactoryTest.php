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
        date_default_timezone_set('Asia/Tokyo');

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
        $this->assertEquals('+0900', $refund->getCreated()->format('O'), 'default timezone is used by default');
        $this->assertEquals(new Money(5000.0, 'JPY'), $refund->getAmount());
    }

    /**
     * @test
     */
    public function it_should_be_timezone_specifiable_for_created()
    {
        $this->SUT = new RefundFactory(new \DateTimeZone('Asia/Singapore'));

        $created = new \DateTime('2015/01/01 10:00:00', new \DateTimeZone('UTC'));
        $json = [
            'created'  => $created->getTimestamp(),
            'amount'   => '5000.0',
            'currency' => 'JPY',
        ];

        $refund = $this->SUT->create($json);
        $this->assertEquals('+0800', $refund->getCreated()->format('O'));
    }
}
