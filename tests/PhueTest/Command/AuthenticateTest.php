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
     * Test: Send authentication command
     *
     * @covers \Phue\Command\Authenticate::send
     * @covers \Phue\Command\Authenticate::buildRequestData
     */
    public function testSend()
    {
        // Stub transport's sendRequest method
        $this->mockTransport->expects($this->once())
                            ->method('sendRequest')
                            ->with(
                                $this->equalTo(''),
                                $this->equalTo('POST'),
                                $this->anything()
                            )
                            ->will($this->returnValue('success!'));

        $this->assertEquals(
            (new Authenticate)->send($this->mockClient),
            'success!'
        );
    }
}
