<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace PhueTest\Command;

use Phue\Command\StartLightScan;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\StartLightScan
 */
class StartLightScanTest extends \PHPUnit_Framework_TestCase
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
     * Test: Send start light scan command
     *
     * @covers \Phue\Command\StartLightScan::send
     */
    public function testSend()
    {
        // Stub transport's sendRequest method
        $this->mockTransport->expects($this->once())
                            ->method('sendRequest')
                            ->with(
                                $this->equalTo($this->mockClient->getUsername() . '/lights'),
                                $this->equalTo('POST')
                            )
                            ->will($this->returnValue('success!'));

        $this->assertEquals(
            (new StartLightScan)->send($this->mockClient),
            'success!'
        );
    }
}
