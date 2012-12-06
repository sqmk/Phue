<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace PhueTest;

use Phue\Client;
use Phue\Transport\TransportInterface;
use Phue\Command\CommandInterface;

/**
 * Tests for Phue\Client
 *
 * @category Phue
 * @package  Phue
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        $this->client = new Client('127.0.0.1');
    }

    /**
     * Test: Creating Client instance
     *
     * @covers \Phue\Client::__construct
     * @covers \Phue\Client::getHost
     * @covers \Phue\Client::setHost
     */
    public function testNewInstance()
    {
        $this->assertEquals(
            $this->client->getHost(),
            '127.0.0.1'
        );
    }

    /**
     * Test: Creating Client instance with non-hashed username
     *
     * @covers \Phue\Client::getUsername
     * @covers \Phue\Client::setUsername
     */
    public function testNewInstanceWithNonHashedUsername()
    {
        $this->client->setUsername('dummy');

        $this->assertEquals(
            $this->client->getUsername(),
            '275876e34cf609db118f3d84b799a790'
        );
    }

    /**
     * Test: Creating Client instance with hashed username
     *
     * @covers \Phue\Client::getUsername
     * @covers \Phue\Client::setUsername
     */
    public function testNewInstanceWithHashedUsername()
    {
        $this->client->setUsername('275876e34cf609db118f3d84b799a790');

        $this->assertEquals(
            $this->client->getUsername(),
            '275876e34cf609db118f3d84b799a790'
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
        $mockTransport = $this->getMock('Phue\Transport\TransportInterface');

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
    public function testSendingCommand()
    {
        $mockCommand = $this->getMock(
            'Phue\Command\CommandInterface',
            array('send')
        );

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
