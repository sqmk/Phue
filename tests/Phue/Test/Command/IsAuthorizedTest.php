<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012-2014 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\Command;

use Phue\Command\IsAuthorized;
use Phue\Client;
use Phue\Transport\TransportInterface;
use Phue\Transport\Exception\UnauthorizedUserException;

/**
 * Tests for Phue\Command\IsAuthorized
 */
class IsAuthorizedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['getTransport'],
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
     * Test: Is authorized
     *
     * @covers \Phue\Command\IsAuthorized::send
     */
    public function testIsAuthorized()
    {
        // Stub transport's sendRequest method
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo($this->mockClient->getUsername()));

        $this->assertTrue(
            (new IsAuthorized)->send($this->mockClient)
        );
    }

    /**
     * Test: Is not authorized
     *
     * @covers \Phue\Command\IsAuthorized::send
     */
    public function testIsNotAuthorized()
    {
        // Stub transport's sendRequest
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo($this->mockClient->getUsername()))
            ->will(
                $this->throwException(
                    $this->getMock('\Phue\Transport\Exception\UnauthorizedUserException')
                )
            );

        $this->assertFalse(
            (new IsAuthorized)->send($this->mockClient)
        );
    }
}
