<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace PhueTest\Command;

use Phue\Command\SetLightState;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\SetLightState
 */
class SetLightStateTest extends \PHPUnit_Framework_TestCase
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
     * Test: Set light on
     *
     * @dataProvider providerOnState
     *
     * @covers \Phue\Command\SetLightState::on
     * @covers \Phue\Command\SetLightState::send
     */
    public function testOnSend($state)
    {
        // Build command
        $command = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'on' => $state
            ]
        );

        // Ensure instance is returned
        $this->assertEquals(
            $command,
            $command->on($state)
        );

        // Send
        $command->send($this->mockClient);
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
     * @dataProvider providerBrightness
     *
     * @covers \Phue\Command\SetLightState::brightness
     * @covers \Phue\Command\SetLightState::send
     */
    public function testBrightnessSend($brightness)
    {
        // Build command
        $command = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'bri' => $brightness
            ]
        );

        // Ensure instance is returned
        $this->assertEquals(
            $command,
            $command->brightness($brightness)
        );

        // Send
        $command->send($this->mockClient);
    }

    /**
     * Test: Invalid hue value
     *
     * @covers \Phue\Command\SetLightState::hue
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidHueValue()
    {
        (new SetLightState($this->mockLight))->hue(70000);
    }

    /**
     * Test: Set hue
     *
     * @dataProvider providerHue
     *
     * @covers \Phue\Command\SetLightState::hue
     * @covers \Phue\Command\SetLightState::send
     */
    public function testHueSend($value)
    {
        // Build command
        $command = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'hue' => $value
            ]
        );

        // Ensure instance is returned
        $this->assertEquals(
            $command,
            $command->hue($value)
        );

        // Send
        $command->send($this->mockClient);
    }

    /**
     * Test: Invalid saturation value
     *
     * @covers \Phue\Command\SetLightState::saturation
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidSaturationValue()
    {
        (new SetLightState($this->mockLight))->saturation(300);
    }

    /**
     * Test: Set alert mode
     *
     * @dataProvider providerSaturation
     *
     * @covers \Phue\Command\SetLightState::saturation
     * @covers \Phue\Command\SetLightState::send
     */
    public function testSaturationSend($value)
    {
        // Build command
        $command = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'sat' => $value
            ]
        );

        // Ensure instance is returned
        $this->assertEquals(
            $command,
            $command->saturation($value)
        );

        // Send
        $command->send($this->mockClient);
    }

    /**
     * Test: Invalid xy value
     *
     * @dataProvider providerInvalidXY
     *
     * @covers \Phue\Command\SetLightState::xy
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidXYValue($x, $y)
    {
        (new SetLightState($this->mockLight))->xy($x, $y);
    }

    /**
     * Test: Set XY
     *
     * @dataProvider providerXY
     *
     * @covers \Phue\Command\SetLightState::xy
     * @covers \Phue\Command\SetLightState::send
     */
    public function testXYSend($x, $y)
    {
        // Build command
        $command = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'xy' => [$x, $y]
            ]
        );

        // Ensure instance is returned
        $this->assertEquals(
            $command,
            $command->xy($x, $y)
        );

        // Send
        $command->send($this->mockClient);
    }

    /**
     * Test: Invalid color temp value
     *
     * @dataProvider providerInvalidColorTemp
     *
     * @covers \Phue\Command\SetLightState::colorTemp
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidColorTempValue($temp)
    {
        (new SetLightState($this->mockLight))->colorTemp($temp);
    }

    /**
     * Test: Set Color temp
     *
     * @dataProvider providerColorTemp
     *
     * @covers \Phue\Command\SetLightState::colorTemp
     * @covers \Phue\Command\SetLightState::send
     */
    public function testColorTempSend($temp)
    {
        // Build command
        $command = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'ct' => $temp
            ]
        );

        // Ensure instance is returned
        $this->assertEquals(
            $command,
            $command->colorTemp($temp)
        );

        // Send
        $command->send($this->mockClient);
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
     * @dataProvider providerAlert
     *
     * @covers \Phue\Command\SetLightState::alert
     * @covers \Phue\Command\SetLightState::send
     */
    public function testAlertSend($mode)
    {
        // Build command
        $command = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'alert' => $mode
            ]
        );

        // Ensure instance is returned
        $this->assertEquals(
            $command,
            $command->alert($mode)
        );

        // Send
        $command->send($this->mockClient);
    }

    /**
     * Test: Get effect modes
     *
     * @covers \Phue\Command\SetLightState::getEffectModes
     */
    public function testGetEffectModes()
    {
        $this->assertNotEmpty(
            SetLightState::getEffectModes()
        );

        $this->assertTrue(
            in_array(SetLightState::EFFECT_NONE, SetLightState::getEffectModes())
        );
    }

    /**
     * Test: Invalid effect mode
     *
     * @covers \Phue\Command\SetLightState::effect
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidEffectMode()
    {
        (new SetLightState($this->mockLight))->effect('invalidmode');
    }

    /**
     * Test: Set effect mode
     *
     * @dataProvider providerEffect
     *
     * @covers \Phue\Command\SetLightState::effect
     * @covers \Phue\Command\SetLightState::send
     */
    public function testEffectSend($mode)
    {
        // Build command
        $command = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'effect' => $mode
            ]
        );

        // Ensure instance is returned
        $this->assertEquals(
            $command,
            $command->effect($mode)
        );

        // Send
        $command->send($this->mockClient);
    }

    /**
     * Test: Invalid transition time
     *
     * @covers \Phue\Command\SetLightState::transitionTime
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidTransitionTime()
    {
        (new SetLightState($this->mockLight))->transitionTime(-10);
    }

    /**
     * Test: Set transition time
     *
     * @dataProvider providerTransitionTime
     *
     * @covers \Phue\Command\SetLightState::transitionTime
     * @covers \Phue\Command\SetLightState::send
     */
    public function testTransitionTimeSend($time)
    {
        // Build command
        $command = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'transitiontime' => $time * 10
            ]
        );

        // Ensure instance is returned
        $this->assertEquals(
            $command,
            $command->transitionTime($time)
        );

        // Send
        $command->send($this->mockClient);
    }

    /**
     * Test: Send command
     *
     * @covers \Phue\Command\SetLightState::__construct
     * @covers \Phue\Command\SetLightState::send
     */
    public function testSend()
    {
        // Build command
        $setLightStateCmd = new SetLightState($this->mockLight);

        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) [
                'alert' => 'select'
            ]
        );

        // Change alert and set state
        $setLightStateCmd->alert('select')
                         ->send($this->mockClient);
    }

    /**
     * Test: Get schedulable params
     *
     * @covers \Phue\Command\SetLightState::getSchedulableParams
     */
    public function testGetSchedulableParams()
    {
        // Build command
        $setLightStateCmd = new SetLightState($this->mockLight);

        // Change alert
        $setLightStateCmd->alert('select');

        // Ensure schedulable params are expected
        $this->assertEquals(
            $setLightStateCmd->getSchedulableParams($this->mockClient),
            [
                'address' => "{$this->mockClient->getUsername()}/lights/{$this->mockLight->getId()}/state",
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
     * Provider: On state
     *
     * @return array
     */
    public function providerOnState()
    {
        return [
            [true],
            [false]
        ];
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
            [256],
        ];
    }

    /**
     * Provider: Valid brightness
     *
     * @return array
     */
    public function providerBrightness()
    {
        return [
            [0],
            [128],
            [255]
        ];
    }

    /**
     * Provider: Hue
     *
     * @return array
     */
    public function providerHue()
    {
        return [
            [10000],
            [35000],
            [42]
        ];
    }

    /**
     * Provider: Saturation
     *
     * @return array
     */
    public function providerSaturation()
    {
        return [
            [0],
            [128],
            [255]
        ];
    }

    /**
     * Provider: Invalid XY
     *
     * @return array
     */
    public function providerInvalidXY()
    {
        return [
            [-0.1, -0.1],
            [.5, -.5],
            [1.1, .5],
            [.5, 1.1]
        ];
    }

    /**
     * Provider: XY
     *
     * @return array
     */
    public function providerXY()
    {
        return [
            [0, 1],
            [.1, .9],
            [.5, .5],
        ];
    }

    /**
     * Provider: Invalid Color temp
     *
     * @return array
     */
    public function providerInvalidColorTemp()
    {
        return [
            [152],
            [550],
            [-130],
        ];
    }

    /**
     * Provider: XY
     *
     * @return array
     */
    public function providerColorTemp()
    {
        return [
            [153],
            [200],
            [500],
        ];
    }

    /**
     * Provider: Alert
     *
     * @return array
     */
    public function providerAlert()
    {
        return [
            [SetLightState::ALERT_NONE],
            [SetLightState::ALERT_SELECT],
            [SetLightState::ALERT_LONG_SELECT],
        ];
    }

    /**
     * Provider: Effect
     *
     * @return array
     */
    public function providerEffect()
    {
        return [
            [SetLightState::EFFECT_NONE],
            [SetLightState::EFFECT_COLORLOOP],
        ];
    }

    /**
     * Provider: Transition time
     *
     * @return array
     */
    public function providerTransitionTime()
    {
        return [
            [1],
            [25],
            [.5]
        ];
    }
}
