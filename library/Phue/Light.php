<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace Phue;

/**
 * Light object
 *
 * @category Phue
 * @package  Phue
 */
class Light
{
    /**
     * Id
     * 
     * @var int
     */
    protected $id;

    /**
     * Light details
     * 
     * @var stdClass
     */
    protected $details;

    /**
     * Construct a Phue Light object
     *
     * @param stdClass $details Light details
     */
    public function __construct($id, \stdClass $details)
    {
        $this->id      = (int) $id;
        $this->details = $details;
    }

    /**
     * Get light Id
     *
     * @return int Light id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get assigned name of light
     *
     * @return string Name of light
     */
    public function getName()
    {
        return $this->details->name;
    }

    /**
     * Is the light on?
     *
     * @return bool True if on, false if not
     */
    public function isOn()
    {
        return (bool) $this->details->state->on;
    }

    /**
     * Get color mode of light
     *
     * @return string Color mode
     */
    public function getColorMode()
    {
        return $this->details->state->colormode;
    }
}
