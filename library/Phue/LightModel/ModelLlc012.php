<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012-2014 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\LightModel;

/**
 * Hue Living Colors Bloom
 */
class ModelLlc012 extends AbstractLightModel
{
    /**
     * Model id
     */
    const MODEL_ID = 'LLC012';

    /**
     * Model name
     */
    const MODEL_NAME = 'Hue Living Colors Bloom';

    /**
     * Can retain state
     */
    const CAN_RETAIN_STATE = true;
}
