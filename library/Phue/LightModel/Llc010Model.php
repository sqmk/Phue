<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\LightModel;

/**
 * Hue Living Colors Iris
 */
class Llc010Model extends AbstractLightModel
{
    /**
     * Model id
     */
    const MODEL_ID = 'LLC010';

    /**
     * Model name
     */
    const MODEL_NAME = 'Hue Living Colors Iris';

    /**
     * Can retain state
     */
    const CAN_RETAIN_STATE = true;
}
