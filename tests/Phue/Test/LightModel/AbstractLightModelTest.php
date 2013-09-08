<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\LightModel;

use Phue\LightModel\AbstractLightModel;

/**
 * Tests for Phue\LightModel\AbstractLightModel
 */
class AbstractLightModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockAbstractLightModel = $this->getMockForAbstractClass(
            '\Phue\LightModel\AbstractLightModel'
        );
    }

    /**
     * Test: Get id
     *
     * @covers \Phue\LightModel\AbstractLightModel::getId
     */
    public function testGetId()
    {
        $this->assertEquals(
            AbstractLightModel::MODEL_ID,
            $this->mockAbstractLightModel->getId()
        );
    }

    /**
     * Test: Get name
     *
     * @covers \Phue\LightModel\AbstractLightModel::getName
     */
    public function testGetName()
    {
        $this->assertEquals(
            AbstractLightModel::MODEL_NAME,
            $this->mockAbstractLightModel->getName()
        );
    }

    /**
     * Test: Can retain state
     *
     * @covers \Phue\LightModel\AbstractLightModel::canRetainState
     */
    public function testCanRetainState()
    {
        $this->assertEquals(
            AbstractLightModel::CAN_RETAIN_STATE,
            $this->mockAbstractLightModel->canRetainState()
        );
    }

    /**
     * Test: To string
     *
     * @covers \Phue\LightModel\AbstractLightModel::__toString
     */
    public function testToString()
    {
        $this->assertEquals(
            AbstractLightModel::MODEL_NAME,
            (string) $this->mockAbstractLightModel
        );
    }
}
