<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

use Phue\Command\SetLightState;

/**
 * Light object
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
     * @param int      $id      Id
     * @param stdClass $details Light details
     * @param Client   $client  Phue client
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
            new Command\SetLightName($this, (string) $name)
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
     * Get effect mode
     *
     * @return string effect mode
     */
    public function getEffect()
    {
        return $this->details->state->effect;
    }

    /**
     * Set effect
     *
     * @param string $mode Effect mode
     *
     * @return Light Self object
     */
    public function setEffect($mode = SetLightState::EFFECT_NONE)
    {
        $this->client->sendCommand(
            (new SetLightState($this))->effect($mode)
        );

        $this->details->state->effect = $mode;

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
    public function setBrightness($level = SetLightState::BRIGHTNESS_MAX)
    {
        $this->client->sendCommand(
            (new SetLightState($this))->brightness((int) $level)
        );

        $this->details->state->bri = (int) $level;

        return $this;
    }

    /**
     * Get hue
     *
     * @return int Hue value
     */
    public function getHue()
    {
        return $this->details->state->hue;
    }

    /**
     * Set hue
     *
     * @param int $value Hue value
     *
     * @return Light Self object
     */
    public function setHue($value)
    {
        $this->client->sendCommand(
            (new SetLightState($this))->hue((int) $value)
        );

        // Change both hue and color mode state
        $this->details->state->hue       = (int) $value;
        $this->details->state->colormode = 'hs';

        return $this;
    }

    /**
     * Get saturation
     *
     * @return int Saturation value
     */
    public function getSaturation()
    {
        return $this->details->state->sat;
    }

    /**
     * Set saturation
     *
     * @param int $value Saturation value
     *
     * @return Light Self object
     */
    public function setSaturation($value)
    {
        $this->client->sendCommand(
            (new SetLightState($this))->saturation((int) $value)
        );

        // Change both saturation and color mode state
        $this->details->state->sat       = (int) $value;
        $this->details->state->colormode = 'hs';

        return $this;
    }

    /**
     * Get XY
     *
     * @return array X, Y key/value
     */
    public function getXY()
    {
        return [
            'x' => $this->details->state->xy[0],
            'y' => $this->details->state->xy[1],
        ];
    }

    /**
     * Set XY
     *
     * @param float $x X value
     * @param float $y Y value
     *
     * @return Light Self object
     */
    public function setXY($x, $y)
    {
        $this->client->sendCommand(
            (new SetLightState($this))->xy((float) $x, (float) $y)
        );

        // Change both internal xy and colormode state
        $this->details->state->xy        = [$x, $y];
        $this->details->state->colormode = 'xy';

        return $this;
    }

    /**
     * Get Color temperature
     *
     * @return int Color temperature value
     */
    public function getColorTemp()
    {
        return $this->details->state->ct;
    }

    /**
     * Set Color temperature
     *
     * @param int $value Color temperature value
     *
     * @return Light Self object
     */
    public function setColorTemp($value)
    {
        $this->client->sendCommand(
            (new SetLightState($this))->colorTemp((int) $value)
        );

        // Change both internal color temp and colormode state
        $this->details->state->ct        = (int) $value;
        $this->details->state->colormode = 'ct';

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
