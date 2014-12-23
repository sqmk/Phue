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
use Phue\Command\GetTimezones;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetTimezones
 */
class GetTimezonesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->getTimezones = new GetTimezones();

        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['getUsername', 'getTransport'],
            ['127.0.0.1']
        );

        // Mock transport
        $this->mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
            ['sendRequest', 'sendRequestBypassBodyValidation']
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
     * @covers \Phue\Command\GetTimezones::send
     */
    public function testGetTimezones()
    {
        // Mock transport results
        $mockTransportResults = [
            'UTC'
        ];

        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequestBypassBodyValidation')
            ->with($this->equalTo("/api/{$this->mockClient->getUsername()}/info/timezones"))
            ->will($this->returnValue($mockTransportResults));

        // Send command and get response
        $response = $this->getTimezones->send($this->mockClient);

        // Ensure we have a bridge object
        $this->assertInternalType('array', $response);
    }
}
