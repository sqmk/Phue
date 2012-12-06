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

use Phue\Command\Authenticate;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\Authenticate
 *
 * @category Phue
 * @package  Phue
 */
class AuthenticateTest extends \PHPUnit_Framework_TestCase
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

        // Mock transport's sendRequest method
        $this->mockTransport->expects($this->once())
                            ->method('sendRequest')
                            ->with($this->equalTo(''),
                                   $this->equalTo('POST'),
                                   $this->anything())
                            ->will($this->returnValue('success!'));

        // Mock client
        $this->mockClient = $this->getMockBuilder('\Phue\Client')
                                 ->setMethods([
                                     'getUsername',
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
     * Test: Send authentication command
     *
     * @covers \Phue\Command\Authenticate::send
     * @covers \Phue\Command\Authenticate::buildRequestData
     */
    public function testSend()
    {
        $authenticate = new Authenticate;

        $this->assertEquals(
            $authenticate->send($this->mockClient),
            'success!'
        );
    }
}
