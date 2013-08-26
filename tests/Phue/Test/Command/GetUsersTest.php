<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\Command;

use Phue\Command\GetUsers;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetUsers
 */
class GetUsersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->getUsers = new GetUsers();

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
     * Test: Found no users
     *
     * @covers \Phue\Command\GetUsers::send
     */
    public function testFoundNoUsers()
    {
        // Stub transport's sendRequest method
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo("{$this->mockClient->getUsername()}/config"))
            ->will($this->returnValue(new \stdClass));

        // Send command and get response
        $response = $this->getUsers->send($this->mockClient);

        // Ensure we have an empty array
        $this->assertInternalType('array', $response);
        $this->assertEmpty($response);
    }

    /**
     * Test: Found users
     *
     * @covers \Phue\Command\GetUsers::send
     */
    public function testFoundUsers()
    {
        // Mock transport results
        $mockTransportResults = (object) [
            'whitelist' => [
                'someusername'    => new \stdClass,
                'anotherusername' => new \stdClass,
            ]
        ];

        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo("{$this->mockClient->getUsername()}/config"))
            ->will($this->returnValue($mockTransportResults));

        // Send command and get response
        $response = $this->getUsers->send($this->mockClient);

        // Ensure we have an array of Users
        $this->assertInternalType('array', $response);
        $this->assertContainsOnlyInstancesOf('\Phue\User', $response);
    }
}
