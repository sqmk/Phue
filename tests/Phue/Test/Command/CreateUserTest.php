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
use Phue\Command\CreateUser;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\CreateUser
 */
class CreateUserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
// TODO        ['getUsername', 'getTransport'],
//             ['127.0.0.1']
        	array('getUsername', 'getTransport'),
        	array('127.0.0.1')
        );

        // Mock transport
        $this->mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
// TODO        ['sendRequest']
        	array('sendRequest')
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
     * Test: Instantiating CreateUser command
     *
     * @covers \Phue\Command\CreateUser::__construct
     * @covers \Phue\Command\CreateUser::setDeviceType
     */
    public function testInstantiation()
    {
        $command = new CreateUser('phpunit');
    }

    /**
     * Test: Setting invalid device type
     *
     * @covers \Phue\Command\CreateUser::setDeviceType
     *
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionOnInvalidDeviceType()
    {
        $command = new CreateUser;
        $command->setDeviceType(str_repeat('X', 41));
    }

    /**
     * Test: Send create user command
     *
     * @covers \Phue\Command\CreateUser::send
     * @covers \Phue\Command\CreateUser::buildRequestData
     */
    public function testSend()
    {
        // Set up device type to pass to create user command
        $deviceType = 'phpunit';

        // Stub transport's sendRequest method
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with(
                $this->equalTo('/api'),
                $this->equalTo('POST'),
                $this->anything()
            )
            ->will($this->returnValue('success!'));

        $x = new CreateUser('phpunit');
        $this->assertEquals(
            'success!',
// TODO        (new CreateUser('phpunit'))->send($this->mockClient)
        	$x->send($this->mockClient)
        );
    }
}
