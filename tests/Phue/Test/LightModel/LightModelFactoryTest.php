<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012-2014 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\LightModel;

use Phue\LightModel\LightModelFactory;

/**
 * Tests for Phue\LightModel\LightModelFactory
 */
class LightModelFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test: Getting unknown model
     *
     * @covers \Phue\LightModel\LightModelFactory::build
     */
    public function testGetUnknownModel()
    {
        $this->assertInstanceOf(
            '\Phue\LightModel\ModelUnknown',
            LightModelFactory::build('whatever')
        );
    }

    /**
     * Test:: Getting known model
     *
     * @covers \Phue\LightModel\LightModelFactory::build
     */
    public function testGetKnownModel()
    {
        $this->assertInstanceOf(
            '\Phue\LightModel\ModelLst001',
            LightModelFactory::build('LST001')
        );
    }
}
