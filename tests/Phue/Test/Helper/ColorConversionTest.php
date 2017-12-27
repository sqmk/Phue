<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue\Test\Helper;
use Phue\Helper\ColorConversion;

/**
 * Tests for Phue\Helper\ColorConversion
 */
class ColorConversionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test: convert RGB to XY and brightness
     * 
     * @covers \Phue\Helper\ColorConversion::convertRGBToXY
     */
    public function testConvertRGBToXY()
    {
        // Values from: http://www.developers.meethue.com/documentation/hue-xy-values

        // Alice Blue
        $xy = ColorConversion::convertRGBToXY(239, 247, 255);
        $this->assertEquals(0.3088, $xy['x'], '', 0.0001);
        $this->assertEquals(0.3212, $xy['y'], '', 0.0001);
        $this->assertEquals(233, $xy['bri']);

        // Firebrick
        $xy = ColorConversion::convertRGBToXY(178, 33, 33);
        $this->assertEquals(0.6622, $xy['x'], '', 0.0001);
        $this->assertEquals(0.3024, $xy['y'], '', 0.0001);
        $this->assertEquals(35, $xy['bri']);

        // Medium Sea Green
        $xy = ColorConversion::convertRGBToXY(61, 178, 112);
        $this->assertEquals(0.1979, $xy['x'], '', 0.0001);
        $this->assertEquals(0.5005, $xy['y'], '', 0.0001);
        $this->assertEquals(81, $xy['bri']);
    }

    /**
     * Test: convert XY and brightness to RGB
     *
     * @covers \Phue\Helper\ColorConversion::convertXYToRGB
     */
    public function testConvertXYToRGB()
    {
        // Conversion back from the test above

        // Alice Blue
        $rgb = ColorConversion::convertXYToRGB(0.3088, 0.3212, 233);
        $this->assertEquals($rgb['red'], 239);
        $this->assertEquals($rgb['green'], 247);
        $this->assertEquals($rgb['blue'], 255);

        // Firebrick
        $rgb = ColorConversion::convertXYToRGB(0.6622, 0.3024, 35);
        $this->assertEquals($rgb['red'], 178);
        $this->assertEquals($rgb['green'], 33);
        $this->assertEquals($rgb['blue'], 33);

        // Medium Sea Green
        $rgb = ColorConversion::convertXYToRGB(0.1979, 0.5005, 81);
        $this->assertEquals($rgb['red'], 61);
        $this->assertEquals($rgb['green'], 178);
        $this->assertEquals($rgb['blue'], 112);
        
        // Test to make sure single RGB values falls within 0..255 range.
        // old situation this was r -18, g 186, b -613.
        $rgb = ColorConversion::convertXYToRGB(0.1979, 1.5005, 81);
        $this->assertEquals($rgb['red'], 0);
        $this->assertEquals($rgb['green'], 186);
        $this->assertEquals($rgb['blue'], 0);
    }
}
