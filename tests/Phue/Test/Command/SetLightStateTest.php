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
use Phue\Command\SetLightState;
use Phue\Helper\ColorConversion;
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
        $this->mockClient = $this->getMock('\Phue\Client', 
            array(
                'getTransport'
            ), array(
                '127.0.0.1'
            ));
        
        // Mock transport
        $this->mockTransport = $this->getMock('\Phue\Transport\TransportInterface', 
            array(
                'sendRequest'
            ));
        
        // Mock light
        $this->mockLight = $this->getMock('\Phue\Light', null, 
            array(
                3,
                new \stdClass(),
                $this->mockClient
            ));
        
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
            (object) array(
                'on' => $state
            ));
        
        // Ensure instance is returned
        $this->assertEquals($command, $command->on($state));
        
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
        $x = new SetLightState($this->mockLight);
        $x->brightness($brightness);
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
            (object) array(
                'bri' => $brightness
            ));
        
        // Ensure instance is returned
        $this->assertEquals($command, $command->brightness($brightness));
        
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
        $x = new SetLightState($this->mockLight);
        $x->hue(70000);
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
            (object) array(
                'hue' => $value
            ));
        
        // Ensure instance is returned
        $this->assertEquals($command, $command->hue($value));
        
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
        $x = new SetLightState($this->mockLight);
        $x->saturation(300);
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
            (object) array(
                'sat' => $value
            ));
        
        // Ensure instance is returned
        $this->assertEquals($command, $command->saturation($value));
        
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
        $_x = new SetLightState($this->mockLight);
        $_x->xy($x, $y);
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
            (object) array(
                'xy' => array(
                    $x,
                    $y
                )
            ));
        
        // Ensure instance is returned
        $this->assertEquals($command, $command->xy($x, $y));
        
        // Send
        $command->send($this->mockClient);
    }

    /**
     * Test: invalid RGB value
     *
     * @dataProvider providerInvalidRGB
     *
     * @covers \Phue\Command\SetLightState::rgb
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidRGBValue($red, $green, $blue)
    {
        $_x = new SetLightState($this->mockLight);
        $_x->rgb($red, $green, $blue);
    }

    /**
     * Test: set XY and brightness via RGB
     *
     * @dataProvider providerRGB
     *
     * @covers \Phue\Command\SetLightState::rgb
     * @covers \Phue\Command\SetLightState::send
     */
    public function testRGBSend($red, $green, $blue)
    {
        // Build command
        $command = new SetLightState($this->mockLight);

        // Set expected payload
        $xy = ColorConversion::convertRGBToXY($red, $green, $blue);
        $this->stubTransportSendRequestWithPayload(
            (object) array(
                'xy' => array(
                    $xy['x'],
                    $xy['y']
                ),
                'bri' => $xy['bri']
            ));

        // Ensure instance is returned
        $this->assertEquals($command, $command->rgb($red, $green, $blue));

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
        $x = new SetLightState($this->mockLight);
        $x->colorTemp($temp);
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
            (object) array(
                'ct' => $temp
            ));
        
        // Ensure instance is returned
        $this->assertEquals($command, $command->colorTemp($temp));
        
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
        $this->assertNotEmpty(SetLightState::getAlertModes());
        
        $this->assertTrue(
            in_array(SetLightState::ALERT_SELECT, SetLightState::getAlertModes()));
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
        $x = new SetLightState($this->mockLight);
        $x->alert('invalidmode');
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
            (object) array(
                'alert' => $mode
            ));
        
        // Ensure instance is returned
        $this->assertEquals($command, $command->alert($mode));
        
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
        $this->assertNotEmpty(SetLightState::getEffectModes());
        
        $this->assertTrue(
            in_array(SetLightState::EFFECT_NONE, SetLightState::getEffectModes()));
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
        $x = new SetLightState($this->mockLight);
        $x->effect('invalidmode');
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
            (object) array(
                'effect' => $mode
            ));
        
        // Ensure instance is returned
        $this->assertEquals($command, $command->effect($mode));
        
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
        $x = new SetLightState($this->mockLight);
        $x->transitionTime(- 10);
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
            (object) array(
                'transitiontime' => $time * 10
            ));
        
        // Ensure instance is returned
        $this->assertEquals($command, $command->transitionTime($time));
        
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
            (object) array(
                'alert' => 'select'
            ));
        
        // Change alert and set state
        $setLightStateCmd->alert('select')->send($this->mockClient);
    }

    /**
     * Test: Get actionable params
     *
     * @covers \Phue\Command\SetLightState::getActionableParams
     */
    public function testGetActionableParams()
    {
        // Build command
        $setLightStateCmd = new SetLightState($this->mockLight);
        
        // Change alert
        $setLightStateCmd->alert('select');
        
        // Ensure actionable params are expected
        $this->assertEquals(
            array(
                'address' => "/lights/{$this->mockLight->getId()}/state",
                'method' => 'PUT',
                'body' => (object) array(
                    'alert' => 'select'
                )
            ), $setLightStateCmd->getActionableParams($this->mockClient));
    }

    /**
     * Stub transport's sendRequest with an expected payload
     *
     * @param \stdClass $payload
     *            Payload
     */
    protected function stubTransportSendRequestWithPayload(\stdClass $payload)
    {
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with(
            $this->equalTo(
                "/api/{$this->mockClient->getUsername()}/lights/{$this->mockLight->getId()}/state"), 
            $this->equalTo('PUT'), $payload);
    }

    /**
     * Provider: On state
     *
     * @return array
     */
    public function providerOnState()
    {
        return array(
            array(
                true
            ),
            array(
                false
            )
        );
    }

    /**
     * Provider: Invalid brightness
     *
     * @return array
     */
    public function providerInvalidBrightness()
    {
        return array(
            array(
                - 1
            ),
            array(
                256
            )
        );
    }

    /**
     * Provider: Valid brightness
     *
     * @return array
     */
    public function providerBrightness()
    {
        return array(
            array(
                0
            ),
            array(
                128
            ),
            array(
                255
            )
        );
    }

    /**
     * Provider: Hue
     *
     * @return array
     */
    public function providerHue()
    {
        return array(
            array(
                10000
            ),
            array(
                35000
            ),
            array(
                42
            )
        );
    }

    /**
     * Provider: Saturation
     *
     * @return array
     */
    public function providerSaturation()
    {
        return array(
            array(
                0
            ),
            array(
                128
            ),
            array(
                255
            )
        );
    }

    /**
     * Provider: Invalid XY
     *
     * @return array
     */
    public function providerInvalidXY()
    {
        return array(
            array(
                - 0.1,
                - 0.1
            ),
            array(
                .5,
                - .5
            ),
            array(
                1.1,
                .5
            ),
            array(
                .5,
                1.1
            )
        );
    }

    /**
     * Provider: XY
     *
     * @return array
     */
    public function providerXY()
    {
        return array(
            array(
                0,
                1
            ),
            array(
                .1,
                .9
            ),
            array(
                .5,
                .5
            )
        );
    }

    /**
     * Provider: Invalid RGB
     *
     * @return array
     */
    public function providerInvalidRGB()
    {
        return array(
            array(
                - 1,
                - 1,
                - 1
            ),
            array(
                50,
                - 50,
                50
            ),
            array(
                256,
                50,
                50
            ),
            array(
                50,
                256,
                50
            ),
            array(
                50,
                50,
                256
            )
        );
    }

    /**
     * Provider: RGB
     *
     * @return array
     */
    public function providerRGB()
    {
        return array(
            array(
                0,
                150,
                255
            ),
            array(
                10,
                135,
                245
            ),
            array(
                150,
                150,
                150
            )
        );
    }

    /**
     * Provider: Invalid Color temp
     *
     * @return array
     */
    public function providerInvalidColorTemp()
    {
        return array(
            array(
                152
            ),
            array(
                550
            ),
            array(
                - 130
            )
        );
    }

    /**
     * Provider: XY
     *
     * @return array
     */
    public function providerColorTemp()
    {
        return array(
            array(
                153
            ),
            array(
                200
            ),
            array(
                500
            )
        );
    }

    /**
     * Provider: Alert
     *
     * @return array
     */
    public function providerAlert()
    {
        return array(
            array(
                SetLightState::ALERT_NONE
            ),
            array(
                SetLightState::ALERT_SELECT
            ),
            array(
                SetLightState::ALERT_LONG_SELECT
            )
        );
    }

    /**
     * Provider: Effect
     *
     * @return array
     */
    public function providerEffect()
    {
        return array(
            array(
                SetLightState::EFFECT_NONE
            ),
            array(
                SetLightState::EFFECT_COLORLOOP
            )
        );
    }

    /**
     * Provider: Transition time
     *
     * @return array
     */
    public function providerTransitionTime()
    {
        return array(
            array(
                1
            ),
            array(
                25
            ),
            array(
                .5
            )
        );
    }
}
