<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\Command;

use Phue\Command\GetNewLights;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetNewLights
 */
class GetNewLightsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->getNewLights = new GetNewLights();

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

        // Mock transport results
        $mockTransportResults = (object) [
            '1'        => (object) ['name' => 'Light 1'],
            '2'        => (object) ['name' => 'Light 2'],
            'lastscan' => 'active'
        ];

        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo("{$this->mockClient->getUsername()}/lights/new"))
            ->will($this->returnValue($mockTransportResults));
    }

    /**
     * Test: Get new lights
     *
     * @covers \Phue\Command\GetNewLights::send
     * @covers \Phue\Command\GetNewLights::getLights
     * @covers \Phue\Command\GetNewLights::isScanActive
     */
    public function testGetNewLights()
    {
        // Send command and get response
        $response = $this->getNewLights->send($this->mockClient);

        // Ensure response is self object
        $this->assertEquals($response, $this->getNewLights);

        // Ensure array of lights
        $this->assertInternalType('array', $response->getLights());

        // Ensure expected number of lights
        $this->assertEquals(count($response->getLights()), 2);

        // Ensure lastscan is active
        $this->assertTrue($response->isScanActive());
    }
}
