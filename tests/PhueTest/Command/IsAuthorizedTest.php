<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace PhueTest\Command;

use Phue\Command\IsAuthorized;
use Phue\Client;
use Phue\Transport\TransportInterface;
use Phue\Transport\Exception\AuthorizationException;

/**
 * Tests for Phue\Command\IsAuthorized
 *
 * @category Phue
 * @package  Phue
 */
class IsAuthorizedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        // Mock transport
        $this->mockTransport = $this->getMockBuilder('\Phue\Transport\TransportInterface')
                                    ->setMethods([
                                        'sendRequest'
                                    ])
                                    ->getMock();

        // Mock client
        $this->mockClient = $this->getMockBuilder('\Phue\Client')
                                 ->setMethods([
                                     'getTransport'
                                 ])
                                 ->setConstructorArgs([
                                     '127.0.0.1'
                                 ])
                                 ->getMock();

        // Mock client's getUsername method
        $this->mockClient->expects($this->any())
                         ->method('getUsername')
                         ->will($this->returnValue('abcdefabcdef01234567890123456789'));

        // Mock client's getTransport method
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
        // Mock transport's sendRequest method
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
        // Mock transport's sendRequest method
        $this->mockTransport->expects($this->once())
                            ->method('sendRequest')
                            ->with($this->equalTo($this->mockClient->getUsername()))
                            ->will($this->throwException(
                                $this->getMock('\Phue\Transport\Exception\AuthorizationException')
                            ));

        $this->assertFalse(
            (new IsAuthorized)->send($this->mockClient)
        );
    }
}
