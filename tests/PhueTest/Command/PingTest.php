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

use Phue\Command\Ping;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\Ping
 *
 * @category Phue
 * @package  Phue
 */
class PingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        // Mock transport
        $this->mockTransport = $this->getMockBuilder('\Phue\Transport\TransportInterface')
                                    ->setMethods([
                                        'sendRequest'
                                    ])
                                    ->getMock();

        // Mock transport's sendRequest method
        $this->mockTransport->expects($this->once())
                            ->method('sendRequest')
                            ->with($this->equalTo('none/config'));

        // Mock client
        $this->mockClient = $this->getMockBuilder('\Phue\Client')
                                 ->setMethods([
                                     'getTransport'
                                 ])
                                 ->setConstructorArgs([
                                     '127.0.0.1'
                                 ])
                                 ->getMock();

        // Mock client's getTransport method
        $this->mockClient->expects($this->any())
                         ->method('getTransport')
                         ->will($this->returnValue($this->mockTransport));
    }

    /**
     * Test: Send ping command
     *
     * @covers \Phue\Command\Ping::send
     */
    public function testSend()
    {
        (new Ping)->send($this->mockClient);
    }
}
