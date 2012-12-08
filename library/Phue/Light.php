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
use Phue\Command\SetLightName;
use Phue\Command\SetLightState;

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
     * @return Light Self object
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
     * Get type
     *
     * @return string Type
     */
    public function getType()
    {
        return $this->details->type;
    }

    /**
     * Get model Id
     *
     * @return string Model Id
     */
    public function getModelId()
    {
        return $this->details->modelid;
    }

    /**
     * Get software version
     *
     * @return string
     */
    public function getSoftwareVersion()
    {
        return $this->details->swversion;
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
     * Set light on/off
     *
     * @param bool $flag True for on, false for off
     *
     * @return Light Self object
     */
    public function setOn($flag = true)
    {
        $this->client->sendCommand(
            (new SetLightState($this))->on((bool) $flag)
        );

        $this->details->state->on = (bool) $flag;

        return $this;
    }

    /**
     * Get alert
     *
     * @return string Alert mode
     */
    public function getAlert()
    {
        return $this->details->state->alert;
    }

    /**
     * Set light alert
     *
     * @param string $mode Alert mode
     *
     * @return Light Self object
     */
    public function setAlert($mode = SetLightState::ALERT_LONG_SELECT)
    {
        $this->client->sendCommand(
            (new SetLightState($this))->alert($mode)
        );

        $this->details->state->alert = $mode;

        return $this;
    }

    /**
     * Get brightness
     *
     * @return int Brightness level
     */
    public function getBrightness()
    {
        return $this->details->state->bri;
    }

    /**
     * Set brightness
     *
     * @param int $level Brightness level
     *
     * @return Light Self object
     */
    public function setBrightness($level = SetLightState::BRIGHTNESS_MIN)
    {
        $this->client->sendCommand(
            (new SetLightState($this))->brightness((int) $level)
        );

        $this->details->state->bri = (int) $level;

        return $this;
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
     * __toString
     *
     * @return string Light Id
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
