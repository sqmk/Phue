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
 * Randomized time
 */
class RandomizedTime extends AbstractTimePattern
{
    /**
     * Date
     *
     * @var DateTime
     */
    protected $date;

    /**
     * Random within seconds
     *
     * @var int
     */
    protected $randomWithinSeconds;

    /**
     * Instantiate
     *
     * @param string $time                Time value
     * @param int    $randomWithinSeconds Random within seconds
     */
    public function __construct($time, $randomWithinSeconds = null)
    {
        $this->date = (new DateTime((string) $time))
            ->setTimeZone(new DateTimeZone('UTC'));

        $this->randomWithinSeconds = $randomWithinSeconds;
    }

    /**
     * To string
     *
     * @return string Formatted date
     */
    public function __toString()
    {
        $time = $this->date->format('Y-m-d\TH:i:s');

        if ($this->randomWithinSeconds !== null) {
            $time .= 'A' . date('H:i:s', $this->randomWithinSeconds);
        }

        return $time;
    }
}
