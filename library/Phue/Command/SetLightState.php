<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Command;

use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Set light alert command
 */
class SetLightState implements CommandInterface, ActionableInterface
{
    /**
     * Brightness min
     */
    const BRIGHTNESS_MIN = 0;

    /**
     * Brightness max
     */
    const BRIGHTNESS_MAX = 255;

    /**
     * Hue min
     */
    const HUE_MIN = 0;

    /**
     * Hue max
     */
    const HUE_MAX = 65535;

    /**
     * Saturation min
     */
    const SATURATION_MIN = 0;

    /**
     * Saturation max
     */
    const SATURATION_MAX = 255;

    /**
     * XY Min
     */
    const XY_MIN = 0.0;

    /**
     * XY Max
     */
    const XY_MAX = 1.0;

    /**
     * Color temperature min
     */
    const COLOR_TEMP_MIN = 153;

    /**
     * Color temperature max
     */
    const COLOR_TEMP_MAX = 500;

    /**
     * Alert none mode
     */
    const ALERT_NONE = 'none';

    /**
     * Alert select mode
     */
    const ALERT_SELECT = 'select';

    /**
     * Alert long select mode
     */
    const ALERT_LONG_SELECT = 'lselect';

    /**
     * Effect none
     */
    const EFFECT_NONE = 'none';

    /**
     * Effect colorloop
     */
    const EFFECT_COLORLOOP = 'colorloop';

    /**
     * Light Id
     *
     * @var string
     */
    protected $lightId;

    /**
     * State parameters
     *
     * @var array
     */
    protected $params = [];

    /**
     * Get alert modes
     *
     * @return array List of alert modes
     */
    public static function getAlertModes()
    {
        return [
            self::ALERT_NONE,
            self::ALERT_SELECT,
            self::ALERT_LONG_SELECT,
        ];
    }

    /**
     * Get effect modes
     *
     * @return array List of color modes
     */
    public static function getEffectModes()
    {
        return [
            self::EFFECT_NONE,
            self::EFFECT_COLORLOOP,
        ];
    }

    /**
     * Constructs a command
     *
     * @param mixed $light Light Id or Light object
     */
    public function __construct($light)
    {
        $this->lightId = (string) $light;
    }

    /**
     * Set on parameter
     *
     * @param bool $flag True if on, false if not
     *
     * @return self This object
     */
    public function on($flag = true)
    {
        $this->params['on'] = (bool) $flag;

        return $this;
    }

    /**
     * Set brightness
     *
     * @param int $level Brightness level
     *
     * @throws \InvalidArgumentException
     *
     * @return self This object
     */
    public function brightness($level = self::BRIGHTNESS_MAX)
    {
        // Don't continue if brightness level is invalid
        if (!(self::BRIGHTNESS_MIN <= $level && $level <= self::BRIGHTNESS_MAX)) {
            throw new \InvalidArgumentException(
                "Brightness must be between " . self::BRIGHTNESS_MIN
                . " and " . self::BRIGHTNESS_MAX
            );
        }

        $this->params['bri'] = (int) $level;

        return $this;
    }

    /**
     * Set hue
     *
     * @param int $value Hue value
     *
     * @throws \InvalidArgumentException
     *
     * @return self This object
     */
    public function hue($value)
    {
        // Don't continue if hue value is invalid
        if (!(self::HUE_MIN <= $value && $value <= self::HUE_MAX)) {
            throw new \InvalidArgumentException(
                "Hue value must be between " . self::HUE_MIN
                . " and " . self::HUE_MAX
            );
        }

        $this->params['hue'] = (int) $value;

        return $this;
    }

    /**
     * Set saturation
     *
     * @param int $value Saturation value
     *
     * @throws \InvalidArgumentException
     *
     * @return self This object
     */
    public function saturation($value)
    {
        // Don't continue if saturation value is invalid
        if (!(self::SATURATION_MIN <= $value && $value <= self::SATURATION_MAX)) {
            throw new \InvalidArgumentException(
                "Saturation value must be between " . self::SATURATION_MIN
                . " and " . self::SATURATION_MAX
            );
        }

        $this->params['sat'] = (int) $value;

        return $this;
    }

    /**
     * Set xy
     *
     * @param float $x X value
     * @param float $y Y value
     *
     * @throws \InvalidArgumentException
     *
     * @return self This object
     */
    public function xy($x, $y)
    {
        // Don't continue if x or y values are invalid
        foreach ([$x, $y] as $value) {
            if (!(self::XY_MIN <= $value && $value <= self::XY_MAX)) {
                throw new \InvalidArgumentException(
                    "x/y value must be between " . self::XY_MIN
                    . " and " . self::XY_MAX
                );
            }
        }

        $this->params['xy'] = [(float) $x, (float) $y];

        return $this;
    }

    /**
     * Set color temperature
     *
     * @param int $value Color temperature value
     *
     * @throws \InvalidArgumentException
     *
     * @return self This object
     */
    public function colorTemp($value)
    {
        // Don't continue if color temperature is invalid
        if (!(self::COLOR_TEMP_MIN <= $value && $value <= self::COLOR_TEMP_MAX)) {
            throw new \InvalidArgumentException(
                "Color temperature value must be between " . self::COLOR_TEMP_MIN
                . " and " . self::COLOR_TEMP_MAX
            );
        }

        $this->params['ct'] = $value;

        return $this;
    }

    /**
     * Set alert parameter
     *
     * @param string $mode Alert mode
     *
     * @throws \InvalidArgumentException
     *
     * @return self This object
     */
    public function alert($mode = self::ALERT_LONG_SELECT)
    {
        // Don't continue if mode is not valid
        if (!in_array($mode, self::getAlertModes())) {
            throw new \InvalidArgumentException(
                "{$mode} is not a valid alert mode"
            );
        }

        $this->params['alert'] = $mode;

        return $this;
    }

    /**
     * Set effect mode
     *
     * @param string $mode Effect mode
     *
     * @throws \InvalidArgumentException
     *
     * @return self This object
     */
    public function effect($mode = self::EFFECT_COLORLOOP)
    {
        // Don't continue if mode is not valid
        if (!in_array($mode, self::getEffectModes())) {
            throw new \InvalidArgumentException(
                "{$mode} is not a valid effect modes"
            );
        }

        $this->params['effect'] = $mode;

        return $this;
    }

    /**
     * Transition time
     *
     * @param double $seconds Time in seconds
     *
     * @throws \InvalidArgumentException
     *
     * @return self This object
     */
    public function transitionTime($seconds)
    {
        // Don't continue if seconds is not valid
        if ((double) $seconds < 0) {
            throw new \InvalidArgumentException(
                "Time must be at least 0"
            );
        }

        // Value is in 1/10 seconds, so convert automatically
        $this->params['transitiontime'] = (int) ($seconds * 10);

        return $this;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     */
    public function send(Client $client)
    {
        // Get params
        $params = $this->getActionableParams($client);

        // Send request
        $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}" . $params['address'],
            $params['method'],
            $params['body']
        );
    }

    /**
     * Get actionable params
     *
     * @param Client $client Phue Client
     *
     * @return array Key/value pairs of params
     */
    public function getActionableParams(Client $client)
    {
        return [
            'address' => "/lights/{$this->lightId}/state",
            'method'  => TransportInterface::METHOD_PUT,
            'body'    => (object) $this->params
        ];
    }
}
