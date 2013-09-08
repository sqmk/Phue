<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test;

use Phue\Light;
use Phue\Client;

/**
 * Tests for Phue\Light
 */
class LightTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['sendCommand'],
            ['127.0.0.1']
        );

        // Build stub attributes
        $this->attributes = (object) [
            'name'      => 'Hue light',
            'type'      => 'Dummy type',
            'modelid'   => 'LCT001',
            'swversion' => '12345',
            'state'     => (object) [
                'on'        => false,
                'bri'       => '66',
                'hue'       => '60123',
                'sat'       => 213,
                'xy'        => [.5, .4],
                'ct'        => 300,
                'alert'     => 'none',
                'effect'    => 'none',
                'colormode' => 'hs',
            ],
        ];

        // Create light object
        $this->light = new Light(5, $this->attributes, $this->mockClient);
    }

    /**
     * Test: Getting Id
     *
     * @covers \Phue\Light::__construct
     * @covers \Phue\Light::getId
     */
    public function testGetId()
    {
        $this->assertEquals(
            $this->light->getId(),
            5
        );
    }

    /**
     * Test: Getting name
     *
     * @covers \Phue\Light::__construct
     * @covers \Phue\Light::getName
     */
    public function testGetName()
    {
        $this->assertEquals(
            $this->light->getName(),
            $this->attributes->name
        );
    }

    /**
     * Test: Setting name
     *
     * @covers \Phue\Light::setName
     * @covers \Phue\Light::getName
     */
    public function testSetName()
    {
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetLightName'))
            ->will($this->returnValue($this->light));

        // Ensure setName returns self
        $this->assertEquals(
            $this->light,
            $this->light->setName('new name')
        );

        // Ensure new name can be retrieved by getName
        $this->assertEquals(
            $this->light->getName(),
            'new name'
        );
    }

    /**
     * Test: Get type
     *
     * @covers \Phue\Light::getType
     */
    public function testGetType()
    {
        $this->assertEquals(
            $this->light->getType(),
            $this->attributes->type
        );
    }

    /**
     * Test: Get model Id
     *
     * @covers \Phue\Light::getModelId
     */
    public function testGetModelId()
    {
        $this->assertEquals(
            $this->light->getModelId(),
            $this->attributes->modelid
        );
    }

    /**
     * Test: Get model
     *
     * @covers \Phue\Light::getModel
     */
    public function testGetModel()
    {
        $this->assertInstanceOf(
            '\Phue\LightModel\AbstractLightModel',
            $this->light->getModel()
        );
    }

    /**
     * Test: Get software version
     *
     * @covers \Phue\Light::getSoftwareVersion
     */
    public function testSoftwareVersion()
    {
        $this->assertEquals(
            $this->light->getSoftwareVersion(),
            $this->attributes->swversion
        );
    }

    /**
     * Test: Is/Set on
     *
     * @covers \Phue\Light::isOn
     * @covers \Phue\Light::setOn
     */
    public function testIsSetOn()
    {
        $this->stubMockClientSendSetLightStateCommand();

        // Make sure original on state is retrievable
        $this->assertFalse($this->light->isOn());

        // Ensure setOn returns self
        $this->assertEquals(
            $this->light,
            $this->light->setOn(true)
        );

        // Make sure light attributes are updated
        $this->assertTrue($this->light->isOn());
    }

    /**
     * Test: Get/Set brightness
     *
     * @covers \Phue\Light::getBrightness
     * @covers \Phue\Light::setBrightness
     */
    public function testGetSetBrightness()
    {
        $this->stubMockClientSendSetLightStateCommand();

        // Make sure original brightness is retrievable
        $this->assertEquals(
            $this->light->getBrightness(),
            $this->attributes->state->bri
        );

        // Ensure setBrightness returns self
        $this->assertEquals(
            $this->light,
            $this->light->setBrightness(254)
        );

        // Make sure light attributes are updated
        $this->assertEquals(
            $this->light->getBrightness(),
            254
        );
    }

    /**
     * Test: Get/Set hue
     *
     * @covers \Phue\Light::getHue
     * @covers \Phue\Light::setHue
     */
    public function testGetSetHue()
    {
        $this->stubMockClientSendSetLightStateCommand();

        // Make sure original hue is retrievable
        $this->assertEquals(
            $this->light->getHue(),
            $this->attributes->state->hue
        );

        // Ensure setHue returns self
        $this->assertEquals(
            $this->light,
            $this->light->setHue(30000)
        );

        // Make sure light attributes are updated
        $this->assertEquals(
            $this->light->getHue(),
            30000
        );
    }

    /**
     * Test: Get/Set saturation
     *
     * @covers \Phue\Light::getSaturation
     * @covers \Phue\Light::setSaturation
     */
    public function testGetSetSaturation()
    {
        $this->stubMockClientSendSetLightStateCommand();

        // Make sure original saturation is retrievable
        $this->assertEquals(
            $this->light->getSaturation(),
            $this->attributes->state->sat
        );

        // Ensure setSaturation returns self
        $this->assertEquals(
            $this->light,
            $this->light->setSaturation(200)
        );

        // Make sure light attributes are updated
        $this->assertEquals(
            $this->light->getSaturation(),
            200
        );
    }

    /**
     * Test: Get/Set XY
     *
     * @covers \Phue\Light::getXY
     * @covers \Phue\Light::setXY
     */
    public function testGetSetXY()
    {
        $this->stubMockClientSendSetLightStateCommand();

        // Make sure original xy is retrievable
        $this->assertEquals(
            $this->light->getXY(),
            [
                'x' => $this->attributes->state->xy[0],
                'y' => $this->attributes->state->xy[1]
            ]
        );

        // Ensure setXY returns self
        $this->assertEquals(
            $this->light,
            $this->light->setXY(.1, .2)
        );

        // Make sure light attributes are updated
        $this->assertEquals(
            $this->light->getXY(),
            ['x' => .1, 'y' => .2]
        );
    }

    /**
     * Test: Get/Set Color temp
     *
     * @covers \Phue\Light::getColorTemp
     * @covers \Phue\Light::setColorTemp
     */
    public function testGetSetColorTemp()
    {
        $this->stubMockClientSendSetLightStateCommand();

        // Make sure original color temp is retrievable
        $this->assertEquals(
            $this->light->getColorTemp(),
            $this->attributes->state->ct
        );

        // Ensure setColorTemp returns self
        $this->assertEquals(
            $this->light,
            $this->light->setColorTemp(412)
        );

        // Make sure light attributes are updated
        $this->assertEquals(
            $this->light->getColorTemp(),
            412
        );
    }

    /**
     * Test: Get/Set alert
     *
     * @covers \Phue\Light::getAlert
     * @covers \Phue\Light::setAlert
     */
    public function testGetSetAlert()
    {
        $this->stubMockClientSendSetLightStateCommand();

        // Make sure original alert is retrievable
        $this->assertEquals(
            $this->light->getAlert(),
            $this->attributes->state->alert
        );

        // Ensure setAlert returns self
        $this->assertEquals(
            $this->light,
            $this->light->setAlert('lselect')
        );

        // Make sure light attributes are updated
        $this->assertEquals(
            $this->light->getAlert(),
            'lselect'
        );
    }

    /**
     * Test: Get/Set effect
     *
     * @covers \Phue\Light::getEffect
     * @covers \Phue\Light::setEffect
     */
    public function testGetSetEffect()
    {
        $this->stubMockClientSendSetLightStateCommand();

        // Make sure original effect is retrievable
        $this->assertEquals(
            $this->light->getEffect(),
            $this->attributes->state->effect
        );

        // Ensure setEffect returns self
        $this->assertEquals(
            $this->light,
            $this->light->setEffect('colorloop')
        );

        // Make sure light attributes are updated
        $this->assertEquals(
            $this->light->getEffect(),
            'colorloop'
        );
    }

    /**
     * Test: Get color mode
     *
     * @covers \Phue\Light::getColorMode
     */
    public function testGetColormode()
    {
        $this->assertEquals(
            $this->light->getColorMode(),
            $this->attributes->state->colormode
        );
    }

    /**
     * Test: toString
     *
     * @covers \Phue\Light::__toString
     */
    public function testToString()
    {
        $this->assertEquals(
            (string) $this->light,
            $this->light->getId()
        );
    }

    /**
     * Stub mock client's send command
     */
    protected function stubMockClientSendSetLightStateCommand()
    {
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetLightState'));
    }
}
