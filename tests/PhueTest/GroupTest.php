<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace PhueTest;

use Phue\Group;
use Phue\Client;

/**
 * Tests for Phue\Group
 *
 * @category Phue
 * @package  Phue
 */
class GroupTest extends \PHPUnit_Framework_TestCase
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
            ['sendCommand'],
            ['127.0.0.1']
        );

        // Build stub details
        $this->details = (object) [
            'name'      => 'Dummy group',
            'action'    => (object) [
                'on'        => false,
                'bri'       => '66',
                'hue'       => '60123',
                'sat'       => 213,
                'xy'        => [.5, .4],
                'ct'        => 300,
                'colormode' => 'hs',
            ],
            'lights'    => [2, 3, 5]
        ];

        // Create group object
        $this->group = new Group(6, $this->details, $this->mockClient);
    }

    /**
     * Test: Getting Id
     *
     * @covers \Phue\Group::__construct
     * @covers \Phue\Group::getId
     */
    public function testGetId()
    {
        $this->assertEquals(
            $this->group->getId(),
            6
        );
    }

    /**
     * Test: Getting name
     *
     * @covers \Phue\Group::__construct
     * @covers \Phue\Group::getName
     */
    public function testGetName()
    {
        $this->assertEquals(
            $this->group->getName(),
            $this->details->name
        );
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
                         ->with($this->isInstanceOf('\Phue\Command\SetGroupConfig'))
                         ->will($this->returnValue($this->group));

        // Ensure setName returns self
        $this->assertEquals(
            $this->group,
            $this->group->setName('new name')
        );

        // Ensure new name can be retrieved by getName
        $this->assertEquals(
            $this->group->getName(),
            'new name'
        );
    }

    /**
     * Test: Get light ids
     *
     * @covers \Phue\Group::getLightIds
     */
    public function testGetLightIds()
    {
        $this->assertEquals(
            $this->group->getLightIds(),
            $this->details->lights
        );
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
                         ->with($this->isInstanceOf('\Phue\Command\SetGroupConfig'))
                         ->will($this->returnValue($this->group));

        // Ensure setLights return self
        $this->assertEquals(
            $this->group,
            $this->group->setLights([1, 2, 3, 4])
        );

        // Ensure lights can be retrieved by getLights
        $this->assertEquals(
            $this->group->getLightIds(),
            [1, 2, 3, 4]
        );
    }

    /**
     * Test: Is/Set on
     *
     * @covers \Phue\Group::isOn
     * @covers \Phue\Group::setOn
     */
    public function testIsSetOn()
    {
        $this->stubMockClientSendSetGroupActionCommand();

        // Make sure original on action is retrievable
        $this->assertFalse($this->group->isOn());

        // Ensure setOn returns self
        $this->assertEquals(
            $this->group,
            $this->group->setOn(true)
        );

        // Make sure group details are updated
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
        $this->stubMockClientSendSetGroupActionCommand();

        // Make sure original brightness is retrievable
        $this->assertEquals(
            $this->group->getBrightness(),
            $this->details->action->bri
        );

        // Ensure setBrightness returns self
        $this->assertEquals(
            $this->group,
            $this->group->setBrightness(254)
        );

        // Make sure group details are updated
        $this->assertEquals(
            $this->group->getBrightness(),
            254
        );
    }

    /**
     * Test: Get/Set hue
     *
     * @covers \Phue\Group::getHue
     * @covers \Phue\Group::setHue
     */
    public function testGetSetHue()
    {
        $this->stubMockClientSendSetGroupActionCommand();

        // Make sure original hue is retrievable
        $this->assertEquals(
            $this->group->getHue(),
            $this->details->action->hue
        );

        // Ensure setHue returns self
        $this->assertEquals(
            $this->group,
            $this->group->setHue(30000)
        );

        // Make sure group details are updated
        $this->assertEquals(
            $this->group->getHue(),
            30000
        );
    }

    /**
     * Test: Get/Set saturation
     *
     * @covers \Phue\Group::getSaturation
     * @covers \Phue\Group::setSaturation
     */
    public function testGetSetSaturation()
    {
        $this->stubMockClientSendSetGroupActionCommand();

        // Make sure original saturation is retrievable
        $this->assertEquals(
            $this->group->getSaturation(),
            $this->details->action->sat
        );

        // Ensure setSaturation returns self
        $this->assertEquals(
            $this->group,
            $this->group->setSaturation(200)
        );

        // Make sure group details are updated
        $this->assertEquals(
            $this->group->getSaturation(),
            200
        );
    }

    /**
     * Test: Get/Set XY
     *
     * @covers \Phue\Group::getXY
     * @covers \Phue\Group::setXY
     */
    public function testGetSetXY()
    {
        $this->stubMockClientSendSetGroupActionCommand();

        // Make sure original xy is retrievable
        $this->assertEquals(
            $this->group->getXY(),
            [
                'x' => $this->details->action->xy[0],
                'y' => $this->details->action->xy[1]
            ]
        );

        // Ensure setXY returns self
        $this->assertEquals(
            $this->group,
            $this->group->setXY(.1, .2)
        );

        // Make sure group details are updated
        $this->assertEquals(
            $this->group->getXY(),
            ['x' => .1, 'y' => .2]
        );
    }

    /**
     * Test: Get/Set Color temp
     *
     * @covers \Phue\Group::getColorTemp
     * @covers \Phue\Group::setColorTemp
     */
    public function testGetSetColorTemp()
    {
        $this->stubMockClientSendSetGroupActionCommand();

        // Make sure original color temp is retrievable
        $this->assertEquals(
            $this->group->getColorTemp(),
            $this->details->action->ct
        );

        // Ensure setColorTemp returns self
        $this->assertEquals(
            $this->group,
            $this->group->setColorTemp(412)
        );

        // Make sure group details are updated
        $this->assertEquals(
            $this->group->getColorTemp(),
            412
        );
    }

    /**
     * Test: Get color mode
     *
     * @covers \Phue\Group::getColorMode
     */
    public function testGetColormode()
    {
        $this->assertEquals(
            $this->group->getColorMode(),
            $this->details->action->colormode
        );
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
        $this->assertEquals(
            (string) $this->group,
            $this->group->getId()
        );
    }

    /**
     * Stub mock client's send command
     *
     * @return void
     */
    protected function stubMockClientSendSetGroupActionCommand()
    {
        $this->mockClient->expects($this->once())
                         ->method('sendCommand')
                         ->with($this->isInstanceOf('\Phue\Command\SetGroupAction'));
    }
}
