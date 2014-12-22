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
 * Absolute time
 */
class AbsoluteTime extends AbstractTimePattern
{
    /**
     * Date
     *
     * @var DateTime
     */
    protected $date;

    /**
     * Instantiate
     *
     * @param string $time Time value
     */
    public function __construct($time)
    {
        $this->date = (new DateTime((string) $time))
            ->setTimeZone(new DateTimeZone('UTC'));
    }

    /**
     * To string
     *
     * @return string Formatted date
     */
    public function __toString()
    {
        return $this->date->format('Y-m-d\TH:i:s');
    }
}
