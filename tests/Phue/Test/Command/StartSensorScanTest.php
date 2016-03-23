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
use Phue\Command\StartSensorScan;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\StartSensorScan
 */
class StartSensorScanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
// TODO             ['getTransport'],
//             ['127.0.0.1']
       		array('getTransport'),
            ('127.0.0.1')
        );

        // Mock transport
        $this->mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
// TODO            ['sendRequest']
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
     * Test: Send start sensor scan command
     *
     * @covers \Phue\Command\StartSensorScan::send
     */
    public function testSend()
    {
        // Stub transport's sendRequest method
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with(
                $this->equalTo("/api/{$this->mockClient->getUsername()}/sensors"),
                $this->equalTo('POST')
            )
            ->will($this->returnValue('success!'));

// TODO         $this->assertEquals(
//             'success!',
//             (new StartSensorScan)->send($this->mockClient)
//         );
		$sensor = new StartSensorScan; 
        $this->assertEquals(
            'success!',
            $sensor->send($this->mockClient)
        );
    }
}
