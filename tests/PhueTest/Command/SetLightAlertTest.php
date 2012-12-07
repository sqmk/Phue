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

use Phue\Command\SetLightAlert;
use Phue\Client;
use Phue\Transport\TransportInterface;
use Phue\Light;

/**
 * Tests for Phue\Command\SetLightAlert
 *
 * @category Phue
 * @package  Phue
 */
class SetLightAlertTest extends \PHPUnit_Framework_TestCase
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
            ['getTransport'],
            ['127.0.0.1']
        );

        // Mock transport
        $this->mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
            ['sendRequest']
        );

        // Mock light
        $this->mockLight = $this->getMock(
            '\Phue\Light',
            null,
            [3, new \stdClass, $this->mockClient]
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
     * Test: Get modes
     * 
     * @covers \Phue\Command\SetLightAlert::getModes
     */
    public function testGetModes()
    {
        $this->assertNotEmpty(
            SetLightAlert::getModes()
        );

        $this->assertTrue(
            in_array(SetLightAlert::MODE_SELECT, SetLightAlert::getModes())
        );
    }

    /**
     * Test: Invalid mode
     *
     * @covers \Phue\Command\SetLightAlert::__construct
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidMode()
    {
        new SetLightAlert($this->mockLight, 'invalidmode');
    }

    /**
     * Test: Set light alert
     *
     * @covers \Phue\Command\SetLightAlert::__construct
     * @covers \Phue\Command\SetLightAlert::send
     */
    public function testSend()
    {
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
                            ->method('sendRequest')
                            ->with(
                                $this->equalTo(
                                    "{$this->mockClient->getUsername()}/lights/{$this->mockLight->getId()}/state"
                                ),
                                $this->equalTo('PUT'),
                                $this->isInstanceOf('\stdClass')
                            );

        (new SetLightAlert($this->mockLight, 'select'))->send($this->mockClient);
    }
}
