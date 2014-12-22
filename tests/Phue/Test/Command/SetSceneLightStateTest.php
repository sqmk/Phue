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
use Phue\Command\SetSceneLightState;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\SetSceneLightState
 */
class SetSceneLightStateTest extends \PHPUnit_Framework_TestCase
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

        // Mock scene
        $this->mockScene = $this->getMock(
            '\Phue\Scene',
            null,
            ['phue-test', new \stdClass, $this->mockClient]
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
     * Test: Send command
     *
     * @covers \Phue\Command\SetSceneLightState::__construct
     * @covers \Phue\Command\SetSceneLightState::send
     */
    public function testSend()
    {
        // Build command
        $setSceneLightStateCmd = new SetSceneLightState(
            $this->mockScene,
            $this->mockLight
        );

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'ct' => '300'
            ]
        );

        // Change color temp and set state
        $setSceneLightStateCmd->colorTemp(300)
            ->send($this->mockClient);
    }

    /**
     * Stub transport's sendRequest with an expected payload
     *
     * @param \stdClass $payload Payload
     */
    protected function stubTransportSendRequestWithPayload(\stdClass $payload)
    {
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with(
                $this->equalTo(
                    "/api/{$this->mockClient->getUsername()}/scenes/{$this->mockScene->getId()}/lights/{$this->mockLight->getId()}/state"
                ),
                $this->equalTo('PUT'),
                $payload
            );
    }
}
