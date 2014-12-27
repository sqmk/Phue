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
 * Hue Living Colors Bloom
 */
class Llc011Model extends AbstractLightModel
{
    /**
     * Model id
     */
    const MODEL_ID = 'LLC011';

    /**
     * Model name
     */
    const MODEL_NAME = 'Hue Living Colors Bloom';

    /**
     * Can retain state
     */
    const CAN_RETAIN_STATE = true;
}
