<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue\Test\TimePattern;

use Phue\TimePattern\AbsoluteTime;

/**
 * Tests for Phue\TimePattern\AbsoluteTime
 */
class AbsoluteTimeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test: Creating absolute time
     *
     * @covers \Phue\TimePattern\AbsoluteTime
     */
    public function testCreateTime()
    {
        $this->assertRegExp('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$/', 
            (string) new AbsoluteTime('now'));
    }
}
