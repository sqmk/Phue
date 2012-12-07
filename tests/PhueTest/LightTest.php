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
        $details                   = new \stdClass;
        $details->name             = 'Hue light';
        $details->state            = new \stdClass;
        $details->state->on        = true;
        $details->state->colormode = 'rgb';

        // Create light object
        $this->light = new Light(5, $details, $this->mockClient);
    }

    /**
     * Test: Getting Id
     *
     * @covers \Phue\Light::__construct
     * @covers \Phue\Light::getId
     */
    public function testGetId()
    {
        $this->assertEquals($this->light->getId(), 5);
    }

    /**
     * Test: Getting name
     *
     * @covers \Phue\Light::__construct
     * @covers \Phue\Light::getName
     */
    public function testGetName()
    {
        $this->assertEquals($this->light->getName(), 'Hue light');
    }

    /**
     * Test: Setting name
     *
     * @covers \Phue\Light::setName
     * @covers \Phue\Light::getName
     */
    public function testSetName()
    {
        // Expect client's sendCommand usage
        $this->mockClient->expects($this->once())
                         ->method('sendCommand')
                         ->with($this->isInstanceOf('\Phue\Command\SetLightName'))
                         ->will($this->returnValue($this->light));

        // Ensure setName returns self
        $this->assertEquals(
            $this->light,
            $this->light->setName('dummy')
        );

        // Ensure new name can be retrieved by getName
        $this->assertEquals(
            'dummy',
            $this->light->getName()
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
     * Test: Get color mode
     *
     * @covers \Phue\Light::getColorMode
     */
    public function testGetColorMode()
    {
        $this->assertEquals($this->light->getColorMode(), 'rgb');
    }

    /**
     * Test: Set alert
     *
     * @covers \Phue\Light::setAlert
     */
    public function testSetAlert()
    {
        // Expect client's sendCommand usage
        $this->mockClient->expects($this->once())
                         ->method('sendCommand')
                         ->with($this->isInstanceOf('\Phue\Command\SetLightAlert'))
                         ->will($this->returnValue($this->light));

        // Ensure setAlert returns self
        $this->assertEquals(
            $this->light,
            $this->light->setAlert('lselect')
        );
    }
}
