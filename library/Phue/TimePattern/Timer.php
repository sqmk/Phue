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
 * Timer
 */
class Timer extends AbstractTimePattern
{
    /**
     * Number of seconds until event
     *
     * @var integer
     */
    protected $seconds = 0;

    /**
     * Number of times to repeat
     *
     * @var integer
     */
    protected $repeat;

    /**
     * Instantiate
     *
     * @param string $time Time value
     */
    public function __construct($seconds)
    {
        $this->seconds = (int) $seconds;
    }

    /**
     * Repeat count.
     *
     * @param int $count Number of times to repeat
     *
     * @return self This object
     */
    public function repeat($count)
    {
        $this->repeat = (int) $count;

        return $this;
    }

    /**
     * To string
     *
     * @return string Formatted date
     */
    public function __toString()
    {
        $timer = 'PT' . date('H:i:s', $this->seconds);

        if ($this->repeat !== null) {
            $timer = sprintf('R%1$02d/%2$s', $this->repeat, $timer);
        }

        return $timer;
    }
}
