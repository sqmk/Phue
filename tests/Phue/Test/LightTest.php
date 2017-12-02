<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue\Test;

use Phue\Client;
use Phue\Helper\ColorConversion;
use Phue\Light;

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
        $this->mockClient = $this->createMock('\Phue\Client', 
            // ['sendCommand'],
            // ['127.0.0.1']
            array(
                'sendCommand'
            ), array(
                '127.0.0.1'
            ));
        
        // Build stub attributes
        $this->attributes = (object) array(
            'name' => 'Hue light',
            'type' => 'Dummy type',
            'modelid' => 'LCT001',
            'uniqueid' => '00:17:88:01:00:bd:d6:54-0d',
            'swversion' => '12345',
            'state' => (object) array(
                'on' => false,
                'bri' => '66',
                'hue' => '60123',
                'sat' => 213,
                'xy' => array(
                    .5,
                    .4
                ),
                'ct' => 300,
                'alert' => 'none',
                'effect' => 'none',
                'colormode' => 'hs',
                'reachable' => true
            )
        );
        
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
        $this->assertEquals(5, $this->light->getId());
    }

    /**
     * Test: Getting name
     *
     * @covers \Phue\Light::__construct
     * @covers \Phue\Light::getName
     */
    public function testGetName()
    {
        $this->assertEquals($this->attributes->name, $this->light->getName());
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
        $this->assertEquals($this->light, $this->light->setName('new name'));
        
        // Ensure new name can be retrieved by getName
        $this->assertEquals('new name', $this->light->getName());
    }

    /**
     * Test: Get type
     *
     * @covers \Phue\Light::getType
     */
    public function testGetType()
    {
        $this->assertEquals($this->attributes->type, $this->light->getType());
    }

    /**
     * Test: Get model Id
     *
     * @covers \Phue\Light::getModelId
     */
    public function testGetModelId()
    {
        $this->assertEquals($this->attributes->modelid, $this->light->getModelId());
    }

    /**
     * Test: Get model
     *
     * @covers \Phue\Light::getModel
     */
    public function testGetModel()
    {
        $this->assertInstanceOf('\Phue\LightModel\AbstractLightModel', 
            $this->light->getModel());
    }

    /**
     * Test: Get unique id
     *
     * @covers \Phue\Light::getUniqueId
     */
    public function testGetUniqueId()
    {
        $this->assertEquals($this->attributes->uniqueid, $this->light->getUniqueId());
    }

    /**
     * Test: Get software version
     *
     * @covers \Phue\Light::getSoftwareVersion
     */
    public function testGetSoftwareVersion()
    {
        $this->assertEquals($this->attributes->swversion, 
            $this->light->getSoftwareVersion());
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
        $this->assertEquals($this->light, $this->light->setOn(true));
        
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
        $this->assertEquals($this->attributes->state->bri, 
            $this->light->getBrightness());
        
        // Ensure setBrightness returns self
        $this->assertEquals($this->light, $this->light->setBrightness(254));
        
        // Make sure light attributes are updated
        $this->assertEquals(254, $this->light->getBrightness());
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
        $this->assertEquals($this->attributes->state->hue, $this->light->getHue());
        
        // Ensure setHue returns self
        $this->assertEquals($this->light, $this->light->setHue(30000));
        
        // Make sure light attributes are updated
        $this->assertEquals(30000, $this->light->getHue());
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
        $this->assertEquals($this->attributes->state->sat, 
            $this->light->getSaturation());
        
        // Ensure setSaturation returns self
        $this->assertEquals($this->light, $this->light->setSaturation(200));
        
        // Make sure light attributes are updated
        $this->assertEquals(200, $this->light->getSaturation());
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
            array(
                'x' => $this->attributes->state->xy[0],
                'y' => $this->attributes->state->xy[1]
            ), $this->light->getXY());
        
        // Ensure setXY returns self
        $this->assertEquals($this->light, $this->light->setXY(0.1, 0.2));
        
        // Make sure light attributes are updated
        $this->assertEquals(
            array(
                'x' => 0.1,
                'y' => 0.2
            ), $this->light->getXY());
    }

    /**
     * Test: Get/Set RGB
     *
     * @covers \Phue\Light::getRGB
     * @covers \Phue\Light::setRGB
     */
    public function testGetSetRGB()
    {
        $this->stubMockClientSendSetLightStateCommand();

        // Make sure original rgb is retrievable
        $rgb = ColorConversion::convertXYToRGB(
            $this->attributes->state->xy[0],
            $this->attributes->state->xy[1],
            $this->attributes->state->bri
        );
        $this->assertEquals(
            array(
                'red' => $rgb['red'],
                'green' => $rgb['green'],
                'blue' => $rgb['blue']
            ), $this->light->getRGB());

        // Ensure setRGB returns self
        $this->assertEquals($this->light, $this->light->setRGB(50, 50, 50));

        // Make sure light attributes are updated
        $this->assertEquals(
            array(
                'red' => 50,
                'green' => 50,
                'blue' => 50
            ), $this->light->getRGB());
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
        $this->assertEquals($this->attributes->state->ct, 
            $this->light->getColorTemp());
        
        // Ensure setColorTemp returns self
        $this->assertEquals($this->light, $this->light->setColorTemp(412));
        
        // Make sure light attributes are updated
        $this->assertEquals(412, $this->light->getColorTemp());
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
        $this->assertEquals($this->attributes->state->alert, 
            $this->light->getAlert());
        
        // Ensure setAlert returns self
        $this->assertEquals($this->light, $this->light->setAlert('lselect'));
        
        // Make sure light attributes are updated
        $this->assertEquals('lselect', $this->light->getAlert());
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
        $this->assertEquals($this->attributes->state->effect, 
            $this->light->getEffect());
        
        // Ensure setEffect returns self
        $this->assertEquals($this->light, $this->light->setEffect('colorloop'));
        
        // Make sure light attributes are updated
        $this->assertEquals('colorloop', $this->light->getEffect());
    }

    /**
     * Test: Get color mode
     *
     * @covers \Phue\Light::getColorMode
     */
    public function testGetColormode()
    {
        $this->assertEquals(
            $this->attributes->state->colormode, 
            $this->light->getColorMode()
        );
    }

    /**
     * Test: Get color mode (missing)
     *
     * @covers \Phue\Light::getColorMode
     */
    public function testGetColormodeMissing()
    {
        $reflection = new \ReflectionClass($this->light);
        $property = $reflection->getProperty('attributes');
        $property->setAccessible(true);

        $property->setValue(
            $this->light,
            (object) array(
                'state' => (object) array()
            )
        );

        $this->assertNull($this->light->getColorMode());
    }

    /**
     * Test: Is reachable
     *
     * @covers \Phue\Light::isReachable
     */
    public function testIsReachable()
    {
        $this->assertEquals($this->attributes->state->reachable, 
            $this->light->isReachable());
    }

    /**
     * Test: toString
     *
     * @covers \Phue\Light::__toString
     */
    public function testToString()
    {
        $this->assertEquals($this->light->getId(), (string) $this->light);
    }

    public function testIssues121_1()
    {
        $attributes = clone $this->attributes;
        $attributes->state->on = false;
        $attributes->state->reachable = false;
        $light = new Light(5, $attributes, $this->mockClient);
        $this->assertFalse($light->isOn());
        $this->assertFalse($light->isReachable());
    }

    public function testIssues121_2()
    {
        $attributes = clone $this->attributes;
        $attributes->state->on = true;
        $attributes->state->reachable = false;
        $light = new Light(5, $attributes, $this->mockClient);
        $this->assertFalse($light->isOn());
        $this->assertFalse($light->isReachable());
    }

    public function testIssues121_3()
    {
        $attributes = clone $this->attributes;
        $attributes->state->on = false;
        $attributes->state->reachable = true;
        $light = new Light(5, $attributes, $this->mockClient);
        $this->assertFalse($light->isOn());
        $this->assertTrue($light->isReachable());
    }

    public function testIssues121_4()
    {
        $attributes = clone $this->attributes;
        $attributes->state->on = true;
        $attributes->state->reachable = true;
        $light = new Light(5, $attributes, $this->mockClient);
        $this->assertTrue($light->isOn());
        $this->assertTrue($light->isReachable());
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
