<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

use Phue\Command\SetGroupConfig;
use Phue\Command\SetGroupAction;
use Phue\Command\SetLightState;
use Phue\Command\DeleteGroup;

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
     * Group details
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
     * Construct a Phue Group object
     *
     * @param int      $id      Id
     * @param stdClass $details Group details
     * @param Client   $client  Phue client
     */
    public function __construct($id, \stdClass $details, Client $client)
    {
        $this->id      = (int) $id;
        $this->details = $details;
        $this->client  = $client;
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
        return $this->details->name;
    }

    /**
     * Set name of group
     *
     * @return Group Self object
     */
    public function setName($name)
    {
        $this->client->sendCommand(
            (new SetGroupConfig($this))->name((string) $name)
        );

        $this->details->name = (string) $name;

        return $this;
    }

    /**
     * Get light ids
     *
     * @return array List of light ids
     */
    public function getLightIds()
    {
        return $this->details->lights;
    }

    /**
     * Set lights
     *
     * @param array $lights Light ids or Light objects
     *
     * @return Group Self object
     */
    public function setLights(array $lights)
    {
        $lightIds = [];

        foreach ($lights as $light) {
            $lightIds[] = (string) $light;
        }

        $this->client->sendCommand(
            (new SetGroupConfig($this))->lights($lightIds)
        );

        $this->details->lights = $lightIds;

        return $this;
    }

    /**
     * Is the group on?
     *
     * @return bool True if on, false if not
     */
    public function isOn()
    {
        return (bool) $this->details->action->on;
    }

    /**
     * Set group lights on/off
     *
     * @param bool $flag True for on, false for off
     *
     * @return Group Self object
     */
    public function setOn($flag = true)
    {
        $this->client->sendCommand(
            (new SetGroupAction($this))->on((bool) $flag)
        );

        $this->details->action->on = (bool) $flag;

        return $this;
    }

    /**
     * Get brightness
     *
     * @return int Brightness level
     */
    public function getBrightness()
    {
        return $this->details->action->bri;
    }

    /**
     * Set brightness
     *
     * @param int $level Brightness level
     *
     * @return Group Self object
     */
    public function setBrightness($level = SetLightState::BRIGHTNESS_MAX)
    {
        $this->client->sendCommand(
            (new SetGroupAction($this))->brightness((int) $level)
        );

        $this->details->action->bri = (int) $level;

        return $this;
    }

    /**
     * Get hue
     *
     * @return int Hue value
     */
    public function getHue()
    {
        return $this->details->action->hue;
    }

    /**
     * Set hue
     *
     * @param int $value Group value
     *
     * @return Group Self object
     */
    public function setHue($value)
    {
        $this->client->sendCommand(
            (new SetGroupAction($this))->hue((int) $value)
        );

        // Change both hue and color mode state
        $this->details->action->hue       = (int) $value;
        $this->details->action->colormode = 'hs';

        return $this;
    }

    /**
     * Get saturation
     *
     * @return int Saturation value
     */
    public function getSaturation()
    {
        return $this->details->action->sat;
    }

    /**
     * Set saturation
     *
     * @param int $value Saturation value
     *
     * @return Group Self object
     */
    public function setSaturation($value)
    {
        $this->client->sendCommand(
            (new SetGroupAction($this))->saturation((int) $value)
        );

        // Change both saturation and color mode state
        $this->details->action->sat       = (int) $value;
        $this->details->action->colormode = 'hs';

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
            'x' => $this->details->action->xy[0],
            'y' => $this->details->action->xy[1],
        ];
    }

    /**
     * Set XY
     *
     * @param float $x X value
     * @param float $y Y value
     *
     * @return Group Self object
     */
    public function setXY($x, $y)
    {
        $this->client->sendCommand(
            (new SetGroupAction($this))->xy((float) $x, (float) $y)
        );

        // Change both internal xy and colormode state
        $this->details->action->xy        = [$x, $y];
        $this->details->action->colormode = 'xy';

        return $this;
    }

    /**
     * Get Color temperature
     *
     * @return int Color temperature value
     */
    public function getColorTemp()
    {
        return $this->details->action->ct;
    }

    /**
     * Set Color temperature
     *
     * @param int $value Color temperature value
     *
     * @return Group Self object
     */
    public function setColorTemp($value)
    {
        $this->client->sendCommand(
            (new SetGroupAction($this))->colorTemp((int) $value)
        );

        // Change both internal color temp and colormode state
        $this->details->action->ct        = (int) $value;
        $this->details->action->colormode = 'ct';

        return $this;
    }

    /**
     * Get effect mode
     *
     * @return string effect mode
     */
    public function getEffect()
    {
        return $this->details->action->effect;
    }

    /**
     * Set effect
     *
     * @param string $mode Effect mode
     *
     * @return Group Self object
     */
    public function setEffect($mode = SetLightState::EFFECT_NONE)
    {
        $this->client->sendCommand(
            (new SetGroupAction($this))->effect($mode)
        );

        $this->details->action->effect = $mode;

        return $this;
    }

    /**
     * Get color mode of group
     *
     * @return string Color mode
     */
    public function getColorMode()
    {
        return $this->details->action->colormode;
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
