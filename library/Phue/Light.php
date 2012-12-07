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

use Phue\Client;
use Phue\Command\SetLightAlert;
use Phue\Command\SetLightName;

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
     * Phue client
     *
     * @var Client
     */
    protected $client;

    /**
     * Construct a Phue Light object
     *
     * @param stdClass $details Light details
     */
    public function __construct($id, \stdClass $details, Client $client)
    {
        $this->id      = (int) $id;
        $this->details = $details;
        $this->client  = $client;
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
     * Set name of light
     *
     * @return Light self object
     */
    public function setName($name)
    {
        $this->client->sendCommand(
            new SetLightName($this, (string) $name)
        );

        $this->details->name = (string) $name;

        return $this;
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

    /**
     * Set light alert
     *
     * @param string $mode Alert mode
     *
     * @return Light self object
     */
    public function setAlert($mode)
    {
        $this->client->sendCommand(
            new SetLightAlert($this, $mode)
        );

        return $this;
    }
}
