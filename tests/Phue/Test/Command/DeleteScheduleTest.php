<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\Command;

use Phue\Client;
use Phue\Command\DeleteSchedule;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\DeleteSchedule
 */
class DeleteScheduleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
// TODO        ['getUsername', 'getTransport'],
//             ['127.0.0.1']
        	array('getUsername', 'getTransport'),
        	array('127.0.0.1')
        );

        // Mock transport
        $this->mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
// TODO        ['sendRequest']
        	array('sendRequest')
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
     * Test: Send command
     *
     * @covers \Phue\Command\DeleteSchedule::__construct
     * @covers \Phue\Command\DeleteSchedule::send
     */
    public function testSend()
    {
        $command = new DeleteSchedule(4);

        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with(
                $this->equalTo("/api/{$this->mockClient->getUsername()}/schedules/4"),
                $this->equalTo(TransportInterface::METHOD_DELETE)
            );

        // Send command
        $command->send($this->mockClient);
    }
}
