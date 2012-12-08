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

use Phue\Command\GetBridge;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetBridge
 *
 * @category Phue
 * @package  Phue
 */
class GetBridgeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        $this->getBridge = new GetBridge();

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
     * Test: Get Bridge
     *
     * @covers \Phue\Command\GetBridge::send
     */
    public function testGetBridge()
    {
        // Mock transport results
        $mockTransportResults = new \stdClass;

        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
                            ->method('sendRequest')
                            ->with($this->equalTo("{$this->mockClient->getUsername()}/config"))
                            ->will($this->returnValue($mockTransportResults));

        // Send command and get response
        $response = $this->getBridge->send($this->mockClient);

        // Ensure we have a bridge object
        $this->assertInstanceOf('\Phue\Bridge', $response);
    }
}
