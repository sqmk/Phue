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

use Phue\Command\StartLightScan;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\StartLightScan
 *
 * @category Phue
 * @package  Phue
 */
class StartLightScanTest extends \PHPUnit_Framework_TestCase
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

        // Mock transport's sendRequest method
        $this->mockTransport->expects($this->once())
                            ->method('sendRequest')
                            ->with(
                                $this->equalTo($this->mockClient->getUsername() . '/lights'),
                                $this->equalTo('POST')
                            )
                            ->will($this->returnValue('success!'));
    }

    /**
     * Test: Send start light scan command
     *
     * @covers \Phue\Command\StartLightScan::send
     */
    public function testSend()
    {
        $this->assertEquals(
            (new StartLightScan)->send($this->mockClient),
            'success!'
        );
    }
}
