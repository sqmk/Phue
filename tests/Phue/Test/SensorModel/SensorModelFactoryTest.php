<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\SensorModel;

use Phue\SensorModel\SensorModelFactory;

/**
 * Tests for Phue\SensorModel\SensorModelFactory
 */
class SensorModelFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test: Getting unknown model
     *
     * @covers \Phue\SensorModel\SensorModelFactory::build
     */
    public function testGetUnknownModel()
    {
        $this->assertInstanceOf(
            '\Phue\SensorModel\UnknownModel',
            SensorModelFactory::build('whatever')
        );
    }

    /**
     * Test:: Getting known model
     *
     * @covers \Phue\SensorModel\SensorModelFactory::build
     */
    public function testGetKnownModel()
    {
        $this->assertInstanceOf(
            '\Phue\SensorModel\ZgpswitchModel',
            SensorModelFactory::build('ZGPSWITCH')
        );
    }
}
