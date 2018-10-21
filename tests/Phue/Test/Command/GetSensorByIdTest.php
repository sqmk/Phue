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
use Phue\Command\GetSensorById;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetSensorById
 */
class GetSensorByIdTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Set up
     */
    public function setUp()
    {
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
        
        // Stub client getTransport usage
        $this->mockClient->expects($this->any())
            ->method('getTransport')
            ->will($this->returnValue($this->mockTransport));
    }

    /**
     * Test: Send get light by id command
     *
     * @covers \Phue\Command\GetSensorById::__construct
     * @covers \Phue\Command\GetSensorById::send
     */
    public function testSend()
    {
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with("/api/{$this->mockClient->getUsername()}/sensors/10")
            ->will($this->returnValue(new \stdClass()));
        
        // Get light
        $x = new GetSensorById(10);
        $sensor = $x->send($this->mockClient);
        
        // Ensure type is correct
        $this->assertInstanceOf('\Phue\Sensor', $sensor);
    }
}
