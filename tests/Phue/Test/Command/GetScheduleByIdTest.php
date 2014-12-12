<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012-2014 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\Command;

use Phue\Command\GetScheduleById;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetScheduleById
 */
class GetScheduleByIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['getTransport'],
            ['127.0.0.1']
        );

        // Mock transport
        $this->mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
            ['sendRequest']
        );

        // Stub client's getUsername method
        $this->mockClient->expects($this->any())
            ->method('getUsername')
            ->will($this->returnValue('abcdefabcdef01234567890123456789'));

        // Stub client getTransport usage
        $this->mockClient->expects($this->any())
            ->method('getTransport')
            ->will($this->returnValue($this->mockTransport));
    }

    /**
     * Test: Send get schedule by id command
     *
     * @covers \Phue\Command\GetScheduleById::__construct
     * @covers \Phue\Command\GetScheduleById::send
     */
    public function testSend()
    {
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with("/api/{$this->mockClient->getUsername()}/schedules/9")
            ->will($this->returnValue(new \stdClass));

        // Get schedule
        $schedule = (new GetScheduleById(9))->send($this->mockClient);

        // Ensure type is correct
        $this->assertInstanceOf(
            '\Phue\Schedule',
            $schedule
        );
    }
}
