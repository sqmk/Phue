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
use Phue\Command\GetNewSensors;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetNewSensors
 */
class GetNewSensorsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Set up
     */
    public function setUp()
    {
        $this->getNewSensors = new GetNewSensors();
        
        // Mock client
        $this->mockClient = $this->createMock('\Phue\Client', 
            array(
                'getUsername',
                'getTransport'
            ), array(
                '127.0.0.1'
            ));
        
        // Mock transport
        $this->mockTransport = $this->createMock('\Phue\Transport\TransportInterface', 
            array(
                'sendRequest'
            ));
        
        // Stub client's getUsername method
        $this->mockClient->expects($this->any())
            ->method('getUsername')
            ->will($this->returnValue('abcdefabcdef01234567890123456789'));
        
        // Stub client's getTransport method
        $this->mockClient->expects($this->any())
            ->method('getTransport')
            ->will($this->returnValue($this->mockTransport));
        
        // Mock transport results
        $mockTransportResults = (object) array(
            '1' => (object) array(
                'name' => 'Sensor 1'
            ),
            '2' => (object) array(
                'name' => 'Sensor 2'
            ),
            'lastscan' => 'active'
        );
        
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with(
            $this->equalTo("/api/{$this->mockClient->getUsername()}/sensors/new"))
            ->will($this->returnValue($mockTransportResults));
    }

    /**
     * Test: Get new sensors
     *
     * @covers \Phue\Command\GetNewSensors::send
     * @covers \Phue\Command\GetNewSensors::getSensors
     * @covers \Phue\Command\GetNewSensors::isScanActive
     */
    public function testGetNewSensors()
    {
        // Send command and get response
        $response = $this->getNewSensors->send($this->mockClient);
        
        // Ensure response is self object
        $this->assertEquals($this->getNewSensors, $response);
        
        // Ensure array of sensors
        $this->assertInternalType('array', $response->getSensors());
        
        // Ensure expected number of sensors
        $this->assertEquals(2, count($response->getSensors()));
        
        // Ensure lastscan is active
        $this->assertTrue($response->isScanActive());
    }
}
