<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012-2014 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\Command;

use Phue\Command\GetSchedules;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetSchedules
 */
class GetSchedulesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->getSchedules = new GetSchedules();

        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['getUsername', 'getTransport'],
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

        // Stub client's getTransport method
        $this->mockClient->expects($this->any())
            ->method('getTransport')
            ->will($this->returnValue($this->mockTransport));
    }

    /**
     * Test: Found no schedules
     *
     * @covers \Phue\Command\GetSchedules::send
     */
    public function testFoundNoSchedules()
    {
        // Stub transport's sendRequest method
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo($this->mockClient->getUsername()))
            ->will($this->returnValue(new \stdClass));

        // Send command and get response
        $response = $this->getSchedules->send($this->mockClient);

        // Ensure we have an empty array
        $this->assertInternalType('array', $response);
        $this->assertEmpty($response);
    }

    /**
     * Test: Found schedules
     *
     * @covers \Phue\Command\GetSchedules::send
     */
    public function testFoundSchedules()
    {
        // Mock transport results
        $mockTransportResults = (object) [
            'schedules' => [
                1 => new \stdClass,
                2 => new \stdClass,
            ]
        ];

        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo($this->mockClient->getUsername()))
            ->will($this->returnValue($mockTransportResults));

        // Send command and get response
        $response = $this->getSchedules->send($this->mockClient);

        // Ensure we have an array of Schedules
        $this->assertInternalType('array', $response);
        $this->assertContainsOnlyInstancesOf('\Phue\Schedule', $response);
    }
}
