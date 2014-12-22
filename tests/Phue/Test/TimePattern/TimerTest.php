<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\TimePattern;

use Phue\TimePattern\Timer;

/**
 * Tests for Phue\TimePattern\Timer
 */
class TimerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test: Creating recurring time
     *
     * @covers \Phue\TimePattern\Timer
     */
    public function testCreateTime()
    {
        $this->assertRegExp(
            '/^R12\/PT01:05:25$/',
            (string) (new Timer(3925))->repeat(12)
        );
    }
}
