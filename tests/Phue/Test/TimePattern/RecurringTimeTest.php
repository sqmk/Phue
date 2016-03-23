<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue\Test\TimePattern;

use Phue\TimePattern\RecurringTime;

/**
 * Tests for Phue\TimePattern\RecurringTime
 */
class RecurringTimeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test: Creating recurring time
     *
     * @covers \Phue\TimePattern\RecurringTime
     */
    public function testCreateTime()
    {
        $this->assertRegExp('/^W34\/T14:02:05$/', 
            (string) new RecurringTime(
                RecurringTime::TUESDAY | RecurringTime::SATURDAY, 14, 2, 5));
    }
}
