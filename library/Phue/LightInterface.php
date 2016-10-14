<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Karim Geiger <geiger@karim.email>
 * @copyright Copyright (c) 2016 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue;

use Phue\Command\SetLightState;

/**
 * Interface for lights and groups.
 */
interface LightInterface
{
    /**
     * Get light or group Id
     *
     * @return int Light/Group id
     */
    public function getId();

    /**
     * Get assigned name of light or group
     *
     * @return string Name of light/group
     */
    public function getName();

    /**
     * Set name of light/group
     *
     * @param string $name
     *
     * @return \Phue\LightInterface
     */
    public function setName($name);

    /**
     * Get type
     *
     * @return string Type
     */
    public function getType();

    /**
     * Is the light or group on?
     *
     * @return bool True if on, false if not
     */
    public function isOn();

    /**
     * Set light or group on/off
     *
     * @param bool $flag
     *            True for on, false for off
     *
     * @return \Phue\LightInterface
     */
    public function setOn($flag = true);

    /**
     * Get alert
     *
     * @return string Alert mode
     */
    public function getAlert();

    /**
     * Set light or group alert
     *
     * @param string $mode
     *            Alert mode
     *
     * @return \Phue\LightInterface
     */
    public function setAlert($mode = SetLightState::ALERT_LONG_SELECT);

    /**
     * Get effect mode
     *
     * @return string effect mode
     */
    public function getEffect();

    /**
     * Set effect
     *
     * @param string $mode
     *            Effect mode
     *
     * @return \Phue\LightInterface
     */
    public function setEffect($mode = SetLightState::EFFECT_NONE);

    /**
     * Get brightness
     *
     * @return int Brightness level
     */
    public function getBrightness();

    /**
     * Set brightness
     *
     * @param int $level
     *            Brightness level
     *
     * @return \Phue\LightInterface
     */
    public function setBrightness($level = SetLightState::BRIGHTNESS_MAX);

    /**
     * Get hue
     *
     * @return int Hue value
     */
    public function getHue();

    /**
     * Set hue
     *
     * @param int $value
     *            Hue value
     *
     * @return \Phue\LightInterface
     */
    public function setHue($value);

    /**
     * Get saturation
     *
     * @return int Saturation value
     */
    public function getSaturation();

    /**
     * Set saturation
     *
     * @param int $value
     *            Saturation value
     *
     * @return \Phue\LightInterface
     */
    public function setSaturation($value);

    /**
     * Get XY
     *
     * @return array X, Y key/value
     */
    public function getXY();

    /**
     * Set XY
     *
     * @param float $x
     *            X value
     * @param float $y
     *            Y value
     *
     * @return \Phue\LightInterface
     */
    public function setXY($x, $y);

    /**
     * Get Color temperature
     *
     * @return int Color temperature value
     */
    public function getColorTemp();

    /**
     * Set Color temperature
     *
     * @param int $value Color temperature value
     *
     * @return \Phue\LightInterface
     */
    public function setColorTemp($value);

    /**
     * Get color mode of light
     *
     * @return string Color mode
     */
    public function getColorMode();
}
