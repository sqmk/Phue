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

use Phue\Command\SetGroupConfig;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\SetGroupConfig
 *
 * @category Phue
 * @package  Phue
 */
class SetGroupConfigTest extends \PHPUnit_Framework_TestCase
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

        // Mock group
        $this->mockGroup = $this->getMock(
            '\Phue\Group',
            null,
            [2, new \stdClass, $this->mockClient]
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
     * @covers \Phue\Command\SetGroupConfig::__construct
     * @covers \Phue\Command\SetGroupConfig::name
     * @covers \Phue\Command\SetGroupConfig::lights
     * @covers \Phue\Command\SetGroupConfig::send
     */
    public function testSend()
    {
        // Build command
        $setGroupConfigCmd = new SetGroupConfig($this->mockGroup);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload((object) [
            'name'   => 'Dummy!',
            'lights' => [3]
        ]);

        // Change name and lights
        $setGroupConfigCmd->name('Dummy!')
                          ->lights([3])
                          ->send($this->mockClient);
    }

    /**
     * Stub transport's sendRequest with an expected payload
     *
     * @param \stdClass $payload Payload
     *
     * @return void
     */
    protected function stubTransportSendRequestWithPayload(\stdClass $payload)
    {
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
                            ->method('sendRequest')
                            ->with(
                                $this->equalTo(
                                    "{$this->mockClient->getUsername()}/groups/{$this->mockGroup->getId()}"
                                ),
                                $this->equalTo('PUT'),
                                $payload
                            );
    }
}
