<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\TimePattern;

/**
 * Time pattern interface
 */
interface TimePatternInterface
{
    /**
     * To string
     *
     * @return string Formatted date
     */
    public function __toString();
}
