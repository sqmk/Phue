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

use Phue\Command\SetGroupAction;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\SetGroupAction
 *
 * @category Phue
 * @package  Phue
 */
class SetGroupActionTest extends \PHPUnit_Framework_TestCase
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
     * @covers \Phue\Command\SetGroupAction::__construct
     * @covers \Phue\Command\SetGroupAction::send
     */
    public function testSend()
    {
        // Build command
        $setGroupActionCmd = new SetGroupAction($this->mockGroup);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'ct' => '300'
            ]
        );

        // Change color temp and set state
        $setGroupActionCmd->colorTemp(300)
                          ->send($this->mockClient);
    }

    /**
     * Test: Get schedulable params
     *
     * @covers \Phue\Command\SetGroupAction::getSchedulableParams
     */
    public function testGetSchedulableParams()
    {
        // Build command
        $setGroupActionCmd = new SetGroupAction($this->mockGroup);

        // Change alert
        $setGroupActionCmd->alert('select');

        // Ensure schedulable params are expected
        $this->assertEquals(
            $setGroupActionCmd->getSchedulableParams($this->mockClient),
            [
                'address' => "{$this->mockClient->getUsername()}/groups/{$this->mockGroup->getId()}/action",
                'method'  => 'PUT',
                'body'    => (object) [
                    'alert' => 'select'
                ]
            ]
        );
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
                                    "{$this->mockClient->getUsername()}/groups/{$this->mockGroup->getId()}/action"
                                ),
                                $this->equalTo('PUT'),
                                $payload
                            );
    }
}
