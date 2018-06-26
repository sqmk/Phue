<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue\Helper;

/**
 * Helper for converting colors to and from rgb
 */
class ColorConversion
{
    /**
     * Converts RGB values to XY values
     * Based on: http://stackoverflow.com/a/22649803
     *
     * @param int $red   Red value
     * @param int $green Green value
     * @param int $blue  Blue value
     *
     * @return array x, y, bri key/value
     */
    public static function convertRGBToXY($red, $green, $blue)
    {
        // Normalize the values to 1
        $normalizedToOne['red'] = $red / 255;
        $normalizedToOne['green'] = $green / 255;
        $normalizedToOne['blue'] = $blue / 255;

        // Make colors more vivid
        foreach ($normalizedToOne as $key => $normalized) {
            if ($normalized > 0.04045) {
                $color[$key] = pow(($normalized + 0.055) / (1.0 + 0.055), 2.4);
            } else {
                $color[$key] = $normalized / 12.92;
            }
        }

        // Convert to XYZ using the Wide RGB D65 formula
        $xyz['x'] = $color['red'] * 0.664511 + $color['green'] * 0.154324 + $color['blue'] * 0.162028;
        $xyz['y'] = $color['red'] * 0.283881 + $color['green'] * 0.668433 + $color['blue'] * 0.047685;
        $xyz['z'] = $color['red'] * 0.000000 + $color['green'] * 0.072310 + $color['blue'] * 0.986039;

        // Calculate the x/y values
        if (array_sum($xyz) == 0) {
            $x = 0;
            $y = 0;
        } else {
            $x = $xyz['x'] / array_sum($xyz);
            $y = $xyz['y'] / array_sum($xyz);
        }

        return array(
            'x'   => $x,
            'y'   => $y,
            'bri' => max($red,$green,$blue)
        );
    }

    /**
     * Converts XY (and brightness) values to RGB
     *
     * @param float $x X value
     * @param float $y Y value
     * @param int $bri Brightness value
     *
     * @return array red, green, blue key/value
     */
    public static function convertXYToRGB($x, $y, $bri = 255)
    {
        // Calculate XYZ
        $z = 1.0 - $x - $y;
        $xyz['y'] = $bri / 255;
        $xyz['x'] = ($xyz['y'] / $y) * $x;
        $xyz['z'] = ($xyz['y'] / $y) * $z;

        // Convert to RGB using Wide RGB D65 conversion
        $color['red'] = $xyz['x'] * 1.656492 - $xyz['y'] * 0.354851 - $xyz['z'] * 0.255038;
        $color['green'] = -$xyz['x'] * 0.707196 + $xyz['y'] * 1.655397 + $xyz['z'] * 0.036152;
        $color['blue'] = $xyz['x'] * 0.051713 - $xyz['y'] * 0.121364 + $xyz['z'] * 1.011530;

        foreach ($color as $key => $normalized) {
            // Apply reverse gamma correction
            if ($normalized <= 0.0031308) {
                $color[$key] = 12.92 * $normalized;
            } else {
                $color[$key] = (1.0 + 0.055) * pow($normalized, 1.0 / 2.4) - 0.055;
            }

            // Scale back from a maximum of 1 to a maximum of 255
            $color[$key] = round($color[$key] * 255);
        }

        return $color;
    }
}
