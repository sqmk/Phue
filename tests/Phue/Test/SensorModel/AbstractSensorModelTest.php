<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue\Test\SensorModel;

use Phue\SensorModel\AbstractSensorModel;

/**
 * Tests for Phue\SensorModel\AbstractSensorModel
 */
class AbstractSensorModelTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockAbstractSensorModel = $this->getMockForAbstractClass(
            '\Phue\SensorModel\AbstractSensorModel');
    }

    /**
     * Test: Get id
     *
     * @covers \Phue\SensorModel\AbstractSensorModel::getId
     */
    public function testGetId()
    {
        $this->assertEquals($this->mockAbstractSensorModel->getId(), 
            AbstractSensorModel::MODEL_ID);
    }

    /**
     * Test: Get name
     *
     * @covers \Phue\SensorModel\AbstractSensorModel::getName
     */
    public function testGetName()
    {
        $this->assertEquals($this->mockAbstractSensorModel->getName(), 
            AbstractSensorModel::MODEL_NAME);
    }

    /**
     * Test: To string
     *
     * @covers \Phue\SensorModel\AbstractSensorModel::__toString
     */
    public function testToString()
    {
        $this->assertEquals((string) $this->mockAbstractSensorModel, 
            AbstractSensorModel::MODEL_NAME);
    }
}
