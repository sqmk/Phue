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
use Phue\Command\GetGroups;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetGroups
 */
class GetGroupsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Set up
     */
    public function setUp()
    {
        $this->getGroups = new GetGroups();
        
        // Mock client
        $this->mockClient = $this->getMock('\Phue\Client', 
            array(
                'getUsername',
                'getTransport'
            ), array(
                '127.0.0.1'
            ));
        
        // Mock transport
        $this->mockTransport = $this->getMock('\Phue\Transport\TransportInterface', 
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
    }

    /**
     * Test: Found no groups
     *
     * @covers \Phue\Command\GetGroups::send
     */
    public function testFoundNoGroups()
    {
        // Stub transport's sendRequest method
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo("/api/{$this->mockClient->getUsername()}/groups"))
            ->will($this->returnValue(new \stdClass()));
        
        // Send command and get response
        $response = $this->getGroups->send($this->mockClient);
        
        // Ensure we have an empty array
        $this->assertInternalType('array', $response);
        $this->assertEmpty($response);
    }

    /**
     * Test: Found groups
     *
     * @covers \Phue\Command\GetGroups::send
     */
    public function testFoundGroups()
    {
        // Mock transport results
        $mockTransportResults = (object) array(
            1 => new \stdClass(),
            2 => new \stdClass()
        );
        
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo("/api/{$this->mockClient->getUsername()}/groups"))
            ->will($this->returnValue($mockTransportResults));
        
        // Send command and get response
        $response = $this->getGroups->send($this->mockClient);
        
        // Ensure we have an array of Groups
        $this->assertInternalType('array', $response);
        $this->assertContainsOnlyInstancesOf('\Phue\Group', $response);
    }
}
