<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace PhueTest\Command;

use Phue\Command\DeleteGroup;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\DeleteGroup
 *
 * @category Phue
 * @package  Phue
 */
class DeleteGroupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
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
     * Test: Send command
     *
     * @covers \Phue\Command\DeleteGroup::__construct
     * @covers \Phue\Command\DeleteGroup::send
     */
    public function testSend()
    {
        $command = new DeleteGroup(5);

        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
                            ->method('sendRequest')
                            ->with(
                                $this->equalTo("{$this->mockClient->getUsername()}/groups/5"),
                                $this->equalTo(TransportInterface::METHOD_DELETE)
                            );

        // Send command
        $command->send($this->mockClient);
    }
}
