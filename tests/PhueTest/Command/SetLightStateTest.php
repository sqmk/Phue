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

use Phue\Command\SetLightState;
use Phue\Client;
use Phue\Transport\TransportInterface;
use Phue\Light;

/**
 * Tests for Phue\Command\SetLightState
 *
 * @category Phue
 * @package  Phue
 */
class SetLightStateTest extends \PHPUnit_Framework_TestCase
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
     * Test: Set light on
     *
     * @covers \Phue\Command\SetLightState::__construct
     * @covers \Phue\Command\SetLightState::on
     * @covers \Phue\Command\SetLightState::send
     */
    public function testSendOn()
    {
        // Build command
        $setLightStateCmd = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload((object) [
            'on' => true
        ]);

        // Change alert and set state
        $setLightStateCmd->on(true)
                         ->send($this->mockClient);
    }

    /**
     * Test: Get alert modes
     *
     * @covers \Phue\Command\SetLightState::getAlertModes
     */
    public function testGetAlertModes()
    {
        $this->assertNotEmpty(
            SetLightState::getAlertModes()
        );

        $this->assertTrue(
            in_array(SetLightState::ALERT_SELECT, SetLightState::getAlertModes())
        );
    }

    /**
     * Test: Invalid brightness
     *
     * @dataProvider providerInvalidBrightness
     *
     * @covers \Phue\Command\SetLightState::brightness
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidBrightness($brightness)
    {
        (new SetLightState($this->mockLight))->brightness($brightness);
    }

    /**
     * Test: Set brightness
     *
     * @dataProvider providerValidBrightness
     *
     * @covers \Phue\Command\SetLightState::brightness
     */
    public function testBrightness($brightness)
    {
        $command = new SetLightState($this->mockLight);

        // Ensure instance is returned
        $this->assertEquals(
            $command,
            $command->brightness($brightness)
        ); 
    }

    /**
     * Test: Invalid alert mode
     *
     * @covers \Phue\Command\SetLightState::alert
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidAlertMode()
    {
        (new SetLightState($this->mockLight))->alert('invalidmode');
    }

    /**
     * Test: Set alert mode
     *
     * @covers \Phue\Command\SetLightState::alert
     */
    public function testAlertMode()
    {
        $command = new SetLightState($this->mockLight);

        // Ensure instance is returned
        $this->assertEquals(
            $command,
            $command->alert(SetLightState::ALERT_SELECT)
        );        
    }

    /**
     * Test: Set light alert
     *
     * @covers \Phue\Command\SetLightState::__construct
     * @covers \Phue\Command\SetLightState::alert
     * @covers \Phue\Command\SetLightState::send
     */
    public function testSendAlert()
    {
        // Build command
        $setLightStateCmd = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload((object) [
            'alert' => 'select'
        ]);

        // Change alert and set state
        $setLightStateCmd->alert('select')
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
                                    "{$this->mockClient->getUsername()}/lights/{$this->mockLight->getId()}/state"
                                ),
                                $this->equalTo('PUT'),
                                $payload
                            );
    }

    /**
     * Provider: Invalid brightness
     *
     * @return array
     */
    public function providerInvalidBrightness()
    {
        return [
            [-1],
            [255],
        ];
    }

    /**
     * Provider: Valid brightness
     *
     * @return array
     */
    public function providerValidBrightness()
    {
        return [
            [0],
            [128],
            [254]
        ];
    }
}
