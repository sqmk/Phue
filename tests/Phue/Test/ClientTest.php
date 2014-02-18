<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012-2014 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test;

use Phue\Client;
use Phue\Transport\TransportInterface;
use Phue\Command\CommandInterface;

/**
 * Tests for Phue\Client
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->client = new Client('127.0.0.1');
    }

    /**
     * Test: Get host
     *
     * @covers \Phue\Client::__construct
     * @covers \Phue\Client::getHost
     * @covers \Phue\Client::setHost
     */
    public function testGetHost()
    {
        $this->assertEquals(
            $this->client->getHost(),
            '127.0.0.1'
        );
    }

    /**
     * Test: Setting non-hashed username
     *
     * @covers \Phue\Client::getUsername
     * @covers \Phue\Client::setUsername
     */
    public function testGetSetUsername()
    {
        $this->client->setUsername('dummy');

        $this->assertEquals(
            $this->client->getUsername(),
            'dummy'
        );
    }

    /**
     * Test: Get bridge
     *
     * @covers \Phue\Client::getBridge
     */
    public function testGetBridge()
    {
        // Mock transport
        $mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
            ['sendRequest']
        );

        // Stub transports sendRequest method
        $mockTransport->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue(new \stdClass));

        // Set transport
        $this->client->setTransport($mockTransport);

        // Ensure return type is Bridge
        $this->assertInstanceOf(
            '\Phue\Bridge',
            $this->client->getBridge()
        );
    }

    /**
     * Test: Get users
     *
     * @covers \Phue\Client::getUsers
     */
    public function testGetUsers()
    {
        // Mock transport
        $mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
            ['sendRequest']
        );

        // Mock results for sendRequest
        $mockResults = (object) [
            'whitelist' => [
                'someusername'    => new \stdClass,
                'anotherusername' => new \stdClass,
                'thirdusername'   => new \stdClass,
            ]
        ];

        // Stub transports sendRequest method
        $mockTransport->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($mockResults));

        // Set transport
        $this->client->setTransport($mockTransport);

        // Get users
        $users = $this->client->getUsers();

        // Ensure at least three users
        $this->assertEquals(3, count($users));

        // Ensure return type is an array of lights
        $this->assertContainsOnlyInstancesOf(
            '\Phue\User',
            $users
        );
    }

    /**
     * Test: Get lights
     *
     * @covers \Phue\Client::getLights
     */
    public function testGetLights()
    {
        // Mock transport
        $mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
            ['sendRequest']
        );

        // Mock results for sendRequest
        $mockResults = (object) [
            'lights' => [
                '1' => new \stdClass,
                '2' => new \stdClass,
            ]
        ];

        // Stub transports sendRequest method
        $mockTransport->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($mockResults));

        // Set transport
        $this->client->setTransport($mockTransport);

        // Get lights
        $lights = $this->client->getLights();

        // Ensure at least two lights
        $this->assertEquals(2, count($lights));

        // Ensure return type is an array of lights
        $this->assertContainsOnlyInstancesOf(
            '\Phue\Light',
            $lights
        );
    }

    /**
     * Test: Get groups
     *
     * @covers \Phue\Client::getGroups
     */
    public function testGetGroups()
    {
        // Mock transport
        $mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
            ['sendRequest']
        );

        // Mock results for sendRequest
        $mockResults = (object) [
            'groups' => [
                '1' => new \stdClass,
                '2' => new \stdClass,
            ]
        ];

        // Stub transports sendRequest method
        $mockTransport->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($mockResults));

        // Set transport
        $this->client->setTransport($mockTransport);

        // Get groups
        $groups = $this->client->getGroups();

        // Ensure at least two groups
        $this->assertEquals(2, count($groups));

        // Ensure return type is an array of groups
        $this->assertContainsOnlyInstancesOf(
            '\Phue\Group',
            $groups
        );
    }

    /**
     * Test: Get schedules
     *
     * @covers \Phue\Client::getSchedules
     */
    public function testGetSchedules()
    {
        // Mock transport
        $mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
            ['sendRequest']
        );

        // Mock results for sendRequest
        $mockResults = (object) [
            'schedules' => [
                '1' => new \stdClass,
                '2' => new \stdClass,
                '3' => new \stdClass,
            ]
        ];

        // Stub transports sendRequest method
        $mockTransport->expects($this->once())
            ->method('sendRequest')
            ->will($this->returnValue($mockResults));

        // Set transport
        $this->client->setTransport($mockTransport);

        // Get schedules
        $schedules = $this->client->getSchedules();

        // Ensure at least three schedules
        $this->assertEquals(3, count($schedules));

        // Ensure return type is an array of schedules
        $this->assertContainsOnlyInstancesOf(
            '\Phue\Schedule',
            $schedules
        );
    }

    /**
     * Test: Not passing in Transport dependency will yield default
     *
     * @covers \Phue\Client::getTransport
     */
    public function testInstantiateDefaultTransport()
    {
        $this->assertInstanceOf(
            '\Phue\Transport\Http',
            $this->client->getTransport()
        );
    }

    /**
     * Test: Passing custom Transport to client
     *
     * @covers \Phue\Client::getTransport
     * @covers \Phue\Client::setTransport
     */
    public function testPassingTransportDependency()
    {
        // Mock transport
        $mockTransport = $this->getMock('\Phue\Transport\TransportInterface');

        $this->client->setTransport($mockTransport);

        $this->assertEquals(
            $mockTransport,
            $this->client->getTransport()
        );
    }

    /**
     * Test: Sending a command
     *
     * @covers \Phue\Client::sendCommand
     */
    public function testSendCommand()
    {
        // Mock command
        $mockCommand = $this->getMock(
            'Phue\Command\CommandInterface',
            ['send']
        );

        // Stub command's send method
        $mockCommand->expects($this->once())
            ->method('send')
            ->with($this->equalTo($this->client))
            ->will($this->returnValue('sample response'));

        $this->assertEquals(
            $this->client->sendCommand($mockCommand),
            'sample response'
        );
    }
}
