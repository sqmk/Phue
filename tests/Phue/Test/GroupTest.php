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
use Phue\Group;

/**
 * Tests for Phue\Group
 */
class GroupTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock('\Phue\Client', 
            // ['sendCommand'],
            // ['127.0.0.1']
            array(
                'sendCommand'
            ), array(
                '127.0.0.1'
            ));
        
        // Build stub attributes
        // $this->attributes = (object) [
        // 'name' => 'Dummy group',
        // 'action' => (object) [
        // 'on' => false,
        // 'bri' => '66',
        // 'hue' => '60123',
        // 'sat' => 213,
        // 'xy' => [0.5, 0.4],
        // 'ct' => 300,
        // 'colormode' => 'hs',
        // 'effect' => 'none',
        // ],
        // 'lights' => [2, 3, 5],
        // 'type' => 'LightGroup',
        // ];
        $this->attributes = (object) array(
            'name' => 'Dummy group',
            'action' => (object) array(
                'on' => false,
                'bri' => '66',
                'hue' => '60123',
                'sat' => 213,
                'xy' => array(
                    0.5,
                    0.4
                ),
                'ct' => 300,
                'colormode' => 'hs',
                'effect' => 'none'
            ),
            'lights' => array(
                2,
                3,
                5
            ),
            'type' => 'LightGroup'
        );
        
        // Create group object
        $this->group = new Group(6, $this->attributes, $this->mockClient);
    }

    /**
     * Test: Getting Id
     *
     * @covers \Phue\Group::__construct
     * @covers \Phue\Group::getId
     */
    public function testGetId()
    {
        $this->assertEquals(6, $this->group->getId());
    }

    /**
     * Test: Getting name
     *
     * @covers \Phue\Group::__construct
     * @covers \Phue\Group::getName
     */
    public function testGetName()
    {
        $this->assertEquals($this->attributes->name, $this->group->getName());
    }

    /**
     * Test: Setting name
     *
     * @covers \Phue\Group::setName
     * @covers \Phue\Group::getName
     */
    public function testSetName()
    {
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetGroupAttributes'))
            ->will($this->returnValue($this->group));
        
        // Ensure setName returns self
        $this->assertEquals($this->group, $this->group->setName('new name'));
        
        // Ensure new name can be retrieved by getName
        $this->assertEquals('new name', $this->group->getName());
    }

    /**
     * Test: Get type
     *
     * @covers \Phue\Group::getType
     */
    public function testGetType()
    {
        $this->assertEquals($this->attributes->type, $this->group->getType());
    }

    /**
     * Test: Get light ids
     *
     * @covers \Phue\Group::getLightIds
     */
    public function testGetLightIds()
    {
        $this->assertEquals($this->attributes->lights, $this->group->getLightIds());
    }

    /**
     * Test: Set lights
     *
     * @covers \Phue\Group::setLights
     * @covers \Phue\Group::getLightIds
     */
    public function testSetLights()
    {
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetGroupAttributes'))
            ->will($this->returnValue($this->group));
        
        // Ensure setLights return self
        $this->assertEquals($this->group, 
            $this->group->setLights(array(
                1,
                2,
                3,
                4
            )));
        
        // Ensure lights can be retrieved by getLights
        $this->assertEquals(
            array(
                1,
                2,
                3,
                4
            ), $this->group->getLightIds());
    }

    /**
     * Test: Is/Set on
     *
     * @covers \Phue\Group::isOn
     * @covers \Phue\Group::setOn
     */
    public function testIsSetOn()
    {
        $this->stubMockClientSendSetGroupStateCommand();
        
        // Make sure original on action is retrievable
        $this->assertFalse($this->group->isOn());
        
        // Ensure setOn returns self
        $this->assertEquals($this->group, $this->group->setOn(true));
        
        // Make sure group attributes are updated
        $this->assertTrue($this->group->isOn());
    }

    /**
     * Test: Get/Set brightness
     *
     * @covers \Phue\Group::getBrightness
     * @covers \Phue\Group::setBrightness
     */
    public function testGetSetBrightness()
    {
        $this->stubMockClientSendSetGroupStateCommand();
        
        // Make sure original brightness is retrievable
        $this->assertEquals($this->attributes->action->bri, 
            $this->group->getBrightness());
        
        // Ensure setBrightness returns self
        $this->assertEquals($this->group, $this->group->setBrightness(254));
        
        // Make sure group attributes are updated
        $this->assertEquals(254, $this->group->getBrightness());
    }

    /**
     * Test: Get/Set hue
     *
     * @covers \Phue\Group::getHue
     * @covers \Phue\Group::setHue
     */
    public function testGetSetHue()
    {
        $this->stubMockClientSendSetGroupStateCommand();
        
        // Make sure original hue is retrievable
        $this->assertEquals($this->attributes->action->hue, $this->group->getHue());
        
        // Ensure setHue returns self
        $this->assertEquals($this->group, $this->group->setHue(30000));
        
        // Make sure group attributes are updated
        $this->assertEquals(30000, $this->group->getHue());
    }

    /**
     * Test: Get/Set saturation
     *
     * @covers \Phue\Group::getSaturation
     * @covers \Phue\Group::setSaturation
     */
    public function testGetSetSaturation()
    {
        $this->stubMockClientSendSetGroupStateCommand();
        
        // Make sure original saturation is retrievable
        $this->assertEquals($this->attributes->action->sat, 
            $this->group->getSaturation());
        
        // Ensure setSaturation returns self
        $this->assertEquals($this->group, $this->group->setSaturation(200));
        
        // Make sure group attributes are updated
        $this->assertEquals(200, $this->group->getSaturation());
    }

    /**
     * Test: Get/Set XY
     *
     * @covers \Phue\Group::getXY
     * @covers \Phue\Group::setXY
     */
    public function testGetSetXY()
    {
        $this->stubMockClientSendSetGroupStateCommand();
        
        // Make sure original xy is retrievable
        $this->assertEquals(
            // [
            // 'x' => $this->attributes->action->xy[0],
            // 'y' => $this->attributes->action->xy[1]
            // ],
            array(
                'x' => $this->attributes->action->xy[0],
                'y' => $this->attributes->action->xy[1]
            ), $this->group->getXY());
        
        // Ensure setXY returns self
        $this->assertEquals($this->group, $this->group->setXY(0.1, 0.2));
        
        // Make sure group attributes are updated
        $this->assertEquals(
            array(
                'x' => 0.1,
                'y' => 0.2
            ), $this->group->getXY());
    }

    /**
     * Test: Get/Set RGB
     *
     * @covers \Phue\Group::getRGB
     * @covers \Phue\Group::setRGB
     */
    public function testGetSetRGB()
    {
        $this->stubMockClientSendSetGroupStateCommand();

        // Make sure original rgb is retrievable
        $rgb = ColorConversion::convertXYToRGB(
            $this->attributes->action->xy[0],
            $this->attributes->action->xy[1],
            $this->attributes->action->bri
        );
        $this->assertEquals(
            array(
                'red' => $rgb['red'],
                'green' => $rgb['green'],
                'blue' => $rgb['blue']
            ), $this->light->getRGB());

        // Ensure setRGB returns self
        $this->assertEquals($this->group, $this->group->setRGB(50, 50, 50));

        // Make sure group attributes are updated
        $this->assertEquals(
            array(
                'red' => 50,
                'green' => 50,
                'blue' => 50
            ), $this->group->getRGB());
    }

    /**
     * Test: Get/Set Color temp
     *
     * @covers \Phue\Group::getColorTemp
     * @covers \Phue\Group::setColorTemp
     */
    public function testGetSetColorTemp()
    {
        $this->stubMockClientSendSetGroupStateCommand();
        
        // Make sure original color temp is retrievable
        $this->assertEquals($this->attributes->action->ct, 
            $this->group->getColorTemp());
        
        // Ensure setColorTemp returns self
        $this->assertEquals($this->group, $this->group->setColorTemp(412));
        
        // Make sure group attributes are updated
        $this->assertEquals(412, $this->group->getColorTemp());
    }

    /**
     * Test: Get/Set effect
     *
     * @covers \Phue\Group::getEffect
     * @covers \Phue\Group::setEffect
     */
    public function testGetSetEffect()
    {
        $this->stubMockClientSendSetGroupStateCommand();
        
        // Make sure original effect is retrievable
        $this->assertEquals($this->attributes->action->effect, 
            $this->group->getEffect());
        
        // Ensure setEffect returns self
        $this->assertEquals($this->group, $this->group->setEffect('colorloop'));
        
        // Make sure group attributes are updated
        $this->assertEquals('colorloop', $this->group->getEffect());
    }

    /**
     * Test: Get color mode
     *
     * @covers \Phue\Group::getColorMode
     */
    public function testGetColormode()
    {
        $this->assertEquals($this->attributes->action->colormode, 
            $this->group->getColorMode());
    }

    /**
     * Test: Set scene
     *
     * @covers \Phue\Group::setScene
     */
    public function testSetScene()
    {
        $this->stubMockClientSendSetGroupStateCommand();
        
        // Ensure setScene returns self
        $this->assertEquals($this->group, $this->group->setScene('phue-test'));
    }

    /**
     * Test: Delete
     *
     * @covers \Phue\Group::delete
     */
    public function testDelete()
    {
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\DeleteGroup'));
        
        $this->group->delete();
    }

    /**
     * Test: toString
     *
     * @covers \Phue\Group::__toString
     */
    public function testToString()
    {
        $this->assertEquals($this->group->getId(), (string) $this->group);
    }

    /**
     * Stub mock client's send command
     */
    protected function stubMockClientSendSetGroupStateCommand()
    {
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetGroupState'));
    }
}
