<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

use Phue\Command\DeleteGroup;
use Phue\Command\SetLightState;
use Phue\Command\SetGroupAttributes;
use Phue\Command\SetGroupState;

/**
 * Group object
 */
class Group
{
    /**
     * Id
     *
     * @var int
     */
    protected $id;

    /**
     * Group attributes
     *
     * @var \stdClass
     */
    protected $attributes;

    /**
     * Phue client
     *
     * @var Client
     */
    protected $client;

    /**
     * Construct a Phue Group object
     *
     * @param int       $id         Id
     * @param \stdClass $attributes Group attributes
     * @param Client    $client     Phue client
     */
    public function __construct($id, \stdClass $attributes, Client $client)
    {
        $this->id         = (int) $id;
        $this->attributes = $attributes;
        $this->client     = $client;
    }

    /**
     * Get group Id
     *
     * @return int Group id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get assigned name of Group
     *
     * @return string Name of Group
     */
    public function getName()
    {
        return $this->attributes->name;
    }

    /**
     * Get type
     *
     * @return string Group type
     */
    public function getType()
    {
        return $this->attributes->type;
    }

    /**
     * Set name of group
     *
     * @param string $name
     *
     * @return self This object
     */
    public function setName($name)
    {
        $this->client->sendCommand(
            (new SetGroupAttributes($this))->name((string) $name)
        );

        $this->attributes->name = (string) $name;

        return $this;
    }

    /**
     * Get light ids
     *
     * @return array List of light ids
     */
    public function getLightIds()
    {
        return $this->attributes->lights;
    }

    /**
     * Set lights
     *
     * @param array $lights Light ids or Light objects
     *
     * @return self This object
     */
    public function setLights(array $lights)
    {
        $lightIds = [];

        foreach ($lights as $light) {
            $lightIds[] = (string) $light;
        }

        $this->client->sendCommand(
            (new SetGroupAttributes($this))->lights($lightIds)
        );

        $this->attributes->lights = $lightIds;

        return $this;
    }

    /**
     * Is the group on?
     *
     * @return bool True if on, false if not
     */
    public function isOn()
    {
        return (bool) $this->attributes->action->on;
    }

    /**
     * Set group lights on/off
     *
     * @param bool $flag True for on, false for off
     *
     * @return self This object
     */
    public function setOn($flag = true)
    {
        $this->client->sendCommand(
            (new SetGroupState($this))->on((bool) $flag)
        );

        $this->attributes->action->on = (bool) $flag;

        return $this;
    }

    /**
     * Get brightness
     *
     * @return int Brightness level
     */
    public function getBrightness()
    {
        return $this->attributes->action->bri;
    }

    /**
     * Set brightness
     *
     * @param int $level Brightness level
     *
     * @return self This object
     */
    public function setBrightness($level = SetLightState::BRIGHTNESS_MAX)
    {
        $this->client->sendCommand(
            (new SetGroupState($this))->brightness((int) $level)
        );

        $this->attributes->action->bri = (int) $level;

        return $this;
    }

    /**
     * Get hue
     *
     * @return int Hue value
     */
    public function getHue()
    {
        return $this->attributes->action->hue;
    }

    /**
     * Set hue
     *
     * @param int $value Group value
     *
     * @return self This object
     */
    public function setHue($value)
    {
        $this->client->sendCommand(
            (new SetGroupState($this))->hue((int) $value)
        );

        // Change both hue and color mode state
        $this->attributes->action->hue       = (int) $value;
        $this->attributes->action->colormode = 'hs';

        return $this;
    }

    /**
     * Get saturation
     *
     * @return int Saturation value
     */
    public function getSaturation()
    {
        return $this->attributes->action->sat;
    }

    /**
     * Set saturation
     *
     * @param int $value Saturation value
     *
     * @return self This object
     */
    public function setSaturation($value)
    {
        $this->client->sendCommand(
            (new SetGroupState($this))->saturation((int) $value)
        );

        // Change both saturation and color mode state
        $this->attributes->action->sat       = (int) $value;
        $this->attributes->action->colormode = 'hs';

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
            'x' => $this->attributes->action->xy[0],
            'y' => $this->attributes->action->xy[1],
        ];
    }

    /**
     * Set XY
     *
     * @param float $x X value
     * @param float $y Y value
     *
     * @return self This object
     */
    public function setXY($x, $y)
    {
        $this->client->sendCommand(
            (new SetGroupState($this))->xy((float) $x, (float) $y)
        );

        // Change both internal xy and colormode state
        $this->attributes->action->xy        = [$x, $y];
        $this->attributes->action->colormode = 'xy';

        return $this;
    }

    /**
     * Get Color temperature
     *
     * @return int Color temperature value
     */
    public function getColorTemp()
    {
        return $this->attributes->action->ct;
    }

    /**
     * Set Color temperature
     *
     * @param int $value Color temperature value
     *
     * @return self This object
     */
    public function setColorTemp($value)
    {
        $this->client->sendCommand(
            (new SetGroupState($this))->colorTemp((int) $value)
        );

        // Change both internal color temp and colormode state
        $this->attributes->action->ct        = (int) $value;
        $this->attributes->action->colormode = 'ct';

        return $this;
    }

    /**
     * Get effect mode
     *
     * @return string effect mode
     */
    public function getEffect()
    {
        return $this->attributes->action->effect;
    }

    /**
     * Set effect
     *
     * @param string $mode Effect mode
     *
     * @return self This object
     */
    public function setEffect($mode = SetLightState::EFFECT_NONE)
    {
        $this->client->sendCommand(
            (new SetGroupState($this))->effect($mode)
        );

        $this->attributes->action->effect = $mode;

        return $this;
    }

    /**
     * Get color mode of group
     *
     * @return string Color mode
     */
    public function getColorMode()
    {
        return $this->attributes->action->colormode;
    }

    /**
     * Set scene on group
     *
     * @param mixed $scene Scene id or Scene object
     *
     * @return self This object
     */
    public function setScene($scene)
    {
        $this->client->sendCommand(
            (new SetGroupState($this))->scene((string) $scene)
        );

        return $this;
    }

    /**
     * Delete group
     */
    public function delete()
    {
        $this->client->sendCommand(
            (new DeleteGroup($this))
        );
    }

    /**
     * __toString
     *
     * @return string Group Id
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
