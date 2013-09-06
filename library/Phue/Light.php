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
     * Hue unknown model.
     */
    const MODEL_UNKNOWN = 'Unknown';

    /**
     * Hue bulb.
     */
    const MODEL_HUE_BULB = 'Hue Bulb';

    /**
     * Hue LightStrips.
     */
    const MODEL_LIGHTSTRIPS = 'LightStrips';

    /**
     * Hue Bloom.
     */
    const MODEL_BLOOM = 'Bloom';

    /**
     * Model ids to models.
     *
     * @var array
     */
    protected static $modelIdToModelMapper = [
        'LCT001' => self::MODEL_HUE_BULB,
        'LST001' => self::MODEL_LIGHTSTRIPS,
        'LLC012' => self::MODEL_BLOOM,
    ];

    /**
     * Id
     *
     * @var int
     */
    protected $id;

    /**
     * Light attributes
     *
     * @var stdClass
     */
    protected $attributes;

    /**
     * Phue client
     *
     * @var Client
     */
    protected $client;

    /**
     * Construct a Phue Light object
     *
     * @param int      $id         Id
     * @param stdClass $attributes Light attributes
     * @param Client   $client     Phue client
     */
    public function __construct($id, \stdClass $attributes, Client $client)
    {
        $this->id         = (int) $id;
        $this->attributes = $attributes;
        $this->client     = $client;
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
        return $this->attributes->name;
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

        $this->attributes->name = (string) $name;

        return $this;
    }

    /**
     * Get type
     *
     * @return string Type
     */
    public function getType()
    {
        return $this->attributes->type;
    }

    /**
     * Get model Id
     *
     * @return string Model Id
     */
    public function getModelId()
    {
        return $this->attributes->modelid;
    }

    /**
     * Get model
     *
     * @return string Model
     */
    public function getModel()
    {
        return isset(self::$modelIdToModelMapper[$this->getModelId()])
            ? self::$modelIdToModelMapper[$this->getModelId()]
            : self::MODEL_UNKNOWN;
    }

    /**
     * Get software version
     *
     * @return string
     */
    public function getSoftwareVersion()
    {
        return $this->attributes->swversion;
    }

    /**
     * Is the light on?
     *
     * @return bool True if on, false if not
     */
    public function isOn()
    {
        return (bool) $this->attributes->state->on;
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

        $this->attributes->state->on = (bool) $flag;

        return $this;
    }

    /**
     * Get alert
     *
     * @return string Alert mode
     */
    public function getAlert()
    {
        return $this->attributes->state->alert;
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

        $this->attributes->state->alert = $mode;

        return $this;
    }

    /**
     * Get effect mode
     *
     * @return string effect mode
     */
    public function getEffect()
    {
        return $this->attributes->state->effect;
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

        $this->attributes->state->effect = $mode;

        return $this;
    }

    /**
     * Get brightness
     *
     * @return int Brightness level
     */
    public function getBrightness()
    {
        return $this->attributes->state->bri;
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

        $this->attributes->state->bri = (int) $level;

        return $this;
    }

    /**
     * Get hue
     *
     * @return int Hue value
     */
    public function getHue()
    {
        return $this->attributes->state->hue;
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
        $this->attributes->state->hue       = (int) $value;
        $this->attributes->state->colormode = 'hs';

        return $this;
    }

    /**
     * Get saturation
     *
     * @return int Saturation value
     */
    public function getSaturation()
    {
        return $this->attributes->state->sat;
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
        $this->attributes->state->sat       = (int) $value;
        $this->attributes->state->colormode = 'hs';

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
            'x' => $this->attributes->state->xy[0],
            'y' => $this->attributes->state->xy[1],
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
        $this->attributes->state->xy        = [$x, $y];
        $this->attributes->state->colormode = 'xy';

        return $this;
    }

    /**
     * Get Color temperature
     *
     * @return int Color temperature value
     */
    public function getColorTemp()
    {
        return $this->attributes->state->ct;
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
        $this->attributes->state->ct        = (int) $value;
        $this->attributes->state->colormode = 'ct';

        return $this;
    }

    /**
     * Get color mode of light
     *
     * @return string Color mode
     */
    public function getColorMode()
    {
        return $this->attributes->state->colormode;
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
