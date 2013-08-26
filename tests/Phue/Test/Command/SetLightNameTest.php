<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\Command;

use Phue\Command\SetLightName;
use Phue\Client;
use Phue\Transport\TransportInterface;
use Phue\Light;

/**
 * Tests for Phue\Command\SetLightName
 */
class SetLightNameTest extends \PHPUnit_Framework_TestCase
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
     * Test: Set light name
     *
     * @covers \Phue\Command\SetLightName::__construct
     * @covers \Phue\Command\SetLightName::send
     */
    public function testSend()
    {
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with(
                $this->equalTo(
                    "{$this->mockClient->getUsername()}/lights/{$this->mockLight->getId()}"
                ),
                $this->equalTo('PUT'),
                $this->isInstanceOf('\stdClass')
            );

        (new SetLightName($this->mockLight, 'Dummy name'))->send($this->mockClient);
    }
}
