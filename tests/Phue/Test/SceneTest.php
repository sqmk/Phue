<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012-2014 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test;

use Phue\Client;
use Phue\Scene;

/**
 * Tests for Phue\Scene
 */
class SceneTest extends \PHPUnit_Framework_TestCase
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
            'name'   => 'Dummy scene',
            'lights' => [2, 3, 5],
            'active' => true,
        ];

        // Create scene object
        $this->scene = new Scene('custom-id', $this->attributes, $this->mockClient);
    }

    /**
     * Test: Getting Id
     *
     * @covers \Phue\Scene::__construct
     * @covers \Phue\Scene::getId
     */
    public function testGetId()
    {
        $this->assertEquals(
            $this->scene->getId(),
            'custom-id'
        );
    }

    /**
     * Test: Getting name
     *
     * @covers \Phue\Scene::__construct
     * @covers \Phue\Scene::getName
     */
    public function testGetName()
    {
        $this->assertEquals(
            $this->scene->getName(),
            $this->attributes->name
        );
    }

    /**
     * Test: Get light ids
     *
     * @covers \Phue\Scene::getLightIds
     */
    public function testGetLightIds()
    {
        $this->assertEquals(
            $this->scene->getLightIds(),
            $this->attributes->lights
        );
    }

    /**
     * Test: Is active
     *
     * @covers \Phue\Scene::isActive
     */
    public function testIsActive()
    {
        $this->assertEquals(
            $this->scene->isActive(),
            $this->attributes->active
        );
    }

    /**
     * Test: toString
     *
     * @covers \Phue\Scene::__toString
     */
    public function testToString()
    {
        $this->assertEquals(
            (string) $this->scene,
            $this->scene->getId()
        );
    }
}
