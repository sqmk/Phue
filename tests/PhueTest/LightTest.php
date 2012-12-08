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

use Phue\Light;
use Phue\Client;

/**
 * Tests for Phue\Light
 *
 * @category Phue
 * @package  Phue
 */
class LightTest extends \PHPUnit_Framework_TestCase
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
            'name'      => 'Hue light',
            'type'      => 'Dummy type',
            'modelid'   => 'M123',
            'swversion' => '12345',
            'state'     => (object) [
                'on'        => true,
                'alert'     => 'none',
                'bri'       => '66',
                'colormode' => 'rgb',
            ],
        ];

        // Create light object
        $this->light = new Light(5, $this->details, $this->mockClient);
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
            $this->details->name
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
            $this->details->type
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
            $this->details->modelid
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
            $this->details->swversion
        );
    }

    /**
     * Test: Light is on?
     *
     * @covers \Phue\Light::isOn
     */
    public function testIsOn()
    {
        $this->assertTrue($this->light->isOn());
    }

    /**
     * Test: Set on
     *
     * @covers \Phue\Light::setOn
     */
    public function testSetOn()
    {
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
                         ->method('sendCommand')
                         ->with($this->isInstanceOf('\Phue\Command\SetLightState'));

        // Ensure setOn returns self
        $this->assertEquals(
            $this->light,
            $this->light->setOn(true)
        );

        // Make sure light details are updated
        $this->assertTrue($this->light->isOn());
    }

    /**
     * Test: Set brightness
     *
     * @covers \Phue\Light::getBrightness
     * @covers \Phue\Light::setBrightness
     */
    public function testGetSetBrightness()
    {
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
                         ->method('sendCommand')
                         ->with($this->isInstanceOf('\Phue\Command\SetLightState'));

        // Make sure original brightness is retrievable
        $this->assertEquals(
            $this->light->getBrightness(),
            66
        );

        // Ensure setBrightness returns self
        $this->assertEquals(
            $this->light,
            $this->light->setBrightness(254)
        );

        // Make sure light details are updated
        $this->assertEquals(
            $this->light->getBrightness(),
            254
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
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
                         ->method('sendCommand')
                         ->with($this->isInstanceOf('\Phue\Command\SetLightState'));

        // Make sure original alert is retrievable
        $this->assertEquals(
            $this->light->getAlert(),
            'none'
        );

        // Ensure setAlert returns self
        $this->assertEquals(
            $this->light,
            $this->light->setAlert('lselect')
        );

        // Make sure light details are updated
        $this->assertEquals(
            $this->light->getAlert(),
            'lselect'
        );
    }

    /**
     * Test: Get color mode
     *
     * @covers \Phue\Light::getColorMode
     */
    public function testGetColorMode()
    {
        $this->assertEquals(
            $this->light->getColorMode(),
            $this->details->state->colormode
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
            5
        );
    }
}
