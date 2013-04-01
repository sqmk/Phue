<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace PhueTest;

use Phue\User;
use Phue\Client;

/**
 * Tests for Phue\User
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['sendCommand'],
            ['127.0.0.1']
        );

        // Stub username
        $this->username = 'phpunittest';

        // Build stub details
        $this->details = (object) [
            'name'          => 'Phue',
            'create date'   => '1984-12-30T03:04:05',
            'last use date' => '1984-12-30T06:07:08',
        ];

        // Create user object
        $this->user = new User($this->username, $this->details, $this->mockClient);
    }

    /**
     * Test: Getting username
     *
     * @covers \Phue\User::__construct
     * @covers \Phue\User::getUsername
     */
    public function testGetUsername()
    {
        $this->assertEquals(
            $this->user->getUsername(),
            $this->username
        );
    }

    /**
     * Test: Getting device type
     *
     * @covers \Phue\User::getDeviceType
     */
    public function testGetDeviceType()
    {
        $this->assertEquals(
            $this->user->getDeviceType(),
            $this->details->name
        );
    }

    /**
     * Test: Getting device type
     *
     * @covers \Phue\User::getCreateDate
     */
    public function testGetCreateDate()
    {
        $this->assertEquals(
            $this->user->getCreateDate(),
            $this->details->{'create date'}
        );
    }

    /**
     * Test: Getting device type
     *
     * @covers \Phue\User::getLastUseDate
     */
    public function testGetLastUseDate()
    {
        $this->assertEquals(
            $this->user->getLastUseDate(),
            $this->details->{'last use date'}
        );
    }

    /**
     * Test: Delete
     *
     * @covers \Phue\User::delete
     */
    public function testDelete()
    {
        $this->mockClient->expects($this->once())
                         ->method('sendCommand')
                         ->with($this->isInstanceOf('\Phue\Command\DeleteUser'));

        $this->user->delete();
    }

    /**
     * Test: toString
     *
     * @covers \Phue\User::__toString
     */
    public function testToString()
    {
        $this->assertEquals(
            (string) $this->user,
            $this->user->getUsername()
        );
    }
}
