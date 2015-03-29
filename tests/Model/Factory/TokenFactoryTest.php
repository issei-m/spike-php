<?php

namespace Issei\Spike\Tests\Model\Factory;

use Issei\Spike\Model\Card;
use Issei\Spike\Model\Factory\TokenFactory;

class TokenFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $dateTimeUtil;

    /**
     * @var TokenFactory
     */
    private $SUT;

    protected function setUp()
    {
        $this->dateTimeUtil = $this->getMockBuilder('Issei\Spike\Util\DateTimeUtil')->disableOriginalConstructor()->getMock();
        $this->SUT = new TokenFactory($this->dateTimeUtil);
    }

    public function testGetName()
    {
        $this->assertEquals('token', $this->SUT->getName());
    }

    public function testCreate()
    {
        $json = [
            'id'       => 'token-id',
            'created'  => 123,
            'source'   => new Card(),
        ];

        $dateTime = new \DateTime('2015/01/01 10:00:00', new \DateTimeZone('UTC'));
        $this->dateTimeUtil->expects($this->once())->method('createDateTimeByUnixTime')->with(123)->will($this->returnValue($dateTime));

        $token = $this->SUT->create($json);
        $this->assertInstanceOf('Issei\Spike\Model\Token', $token);
        $this->assertEquals('token-id', $token->getId());
        $this->assertEquals($dateTime, $token->getCreated());
        $this->assertEquals($json['source'], $token->getSource());
    }
}
