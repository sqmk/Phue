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
        // Build stub details
        $details                   = new \stdClass;
        $details->name             = 'Hue light';
        $details->state            = new \stdClass;
        $details->state->on        = true;
        $details->state->colormode = 'rgb';

        // Create light object
        $this->light = new Light(5, $details);
    }

    /**
     * Test: Getting Id
     *
     * @covers \Phue\Light::__construct
     * @covers \Phue\Light::getId
     */
    public function testGettingId()
    {
        $this->assertEquals($this->light->getId(), 5);
    }

    /**
     * Test: Getting name
     *
     * @covers \Phue\Light::__construct
     * @covers \Phue\Light::getName
     */
    public function testGettingName()
    {
        $this->assertEquals($this->light->getName(), 'Hue light');
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
}
