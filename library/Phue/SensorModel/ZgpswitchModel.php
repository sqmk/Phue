<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\SensorModel;

/**
 * ZGPSwitch model
 */
class ZgpswitchModel extends AbstractSensorModel
{
    /**
     * Model id
     */
    const MODEL_ID = 'ZGPSWITCH';

    /**
     * Model name
     */
    const MODEL_NAME = 'ZGP Switch';

    /**
     * Button 1 code.
     */
    const BUTTON_1 = 34;

    /**
     * Button 2 code.
     */
    const BUTTON_2 = 16;

    /**
     * Button 3 code.
     */
    const BUTTON_3 = 17;

    /**
     * Button 4 code.
     */
    const BUTTON_4 = 18;
}
