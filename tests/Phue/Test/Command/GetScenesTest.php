<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012-2014 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\Command;

use Phue\Command\GetScenes;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetScenes
 */
class GetScenesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->getScenes = new GetScenes();

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
     * Test: Found no scenes
     *
     * @covers \Phue\Command\GetScenes::send
     */
    public function testFoundNoScenes()
    {
        // Stub transport's sendRequest method
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo("/api/{$this->mockClient->getUsername()}/scenes"))
            ->will($this->returnValue(new \stdClass));

        // Send command and get response
        $response = $this->getScenes->send($this->mockClient);

        // Ensure we have an empty array
        $this->assertInternalType('array', $response);
        $this->assertEmpty($response);
    }

    /**
     * Test: Found scenes
     *
     * @covers \Phue\Command\GetScenes::send
     */
    public function testFoundScenes()
    {
        // Mock transport results
        $mockTransportResults = (object) [
            1 => new \stdClass,
            2 => new \stdClass,
        ];

        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo("/api/{$this->mockClient->getUsername()}/scenes"))
            ->will($this->returnValue($mockTransportResults));

        // Send command and get response
        $response = $this->getScenes->send($this->mockClient);

        // Ensure we have an array of Scenes
        $this->assertInternalType('array', $response);
        $this->assertContainsOnlyInstancesOf('\Phue\Scene', $response);
    }
}
