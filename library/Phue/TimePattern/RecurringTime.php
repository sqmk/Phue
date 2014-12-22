<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\TimePattern;

use DateTime;
use DateTimeZone;

/**
 * Recurring time
 */
class RecurringTime extends AbstractTimePattern
{
    /**
     * Days of the week.
     */
    const MONDAY    = 64;
    const TUESDAY   = 32;
    const WEDNESDAY = 16;
    const THURSDAY  = 8;
    const FRIDAY    = 4;
    const SATURDAY  = 2;
    const SUNDAY    = 1;

    /**
     * Groups of days.
     */
    const WEEKDAY = 124;
    const WEEKEND = 3;

    /**
     * Days of week
     *
     * @var int
     */
    protected $daysOfWeek;

    /**
     * Time of day
     *
     * @var string
     */
    protected $timeOfDay;

    /**
     * Instantiate
     *
     * @param int $daysOfWeek Bitmask of days (MONDAY|WEDNESDAY|FRIDAY)
     * @param int $hour       Hour.
     * @param int $minute     Minute.
     * @param int $second     Second.
     */
    public function __construct($daysOfWeek, $hour = 0, $minute = 0, $second = 0)
    {
        $this->daysOfWeek = (int) $daysOfWeek;

        $this->timeOfDay = (new DateTime)
            ->setTime($hour, $minute, $second)
            ->setTimeZone(new DateTimeZone('UTC'))
            ->format('H:i:s');
    }

    /**
     * To string
     *
     * @return string Formatted date
     */
    public function __toString()
    {
        $time = "W{$this->daysOfWeek}/T{$this->timeOfDay}";

        return $time;
    }
}
