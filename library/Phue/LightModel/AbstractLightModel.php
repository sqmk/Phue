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
 * Abstract light model
 */
abstract class AbstractLightModel
{
    /**
     * Model id
     */
    const MODEL_ID = 'model id';

    /**
     * Model name
     */
    const MODEL_NAME = 'model name';

    /**
     * Can retain state
     */
    const CAN_RETAIN_STATE = false;

    /**
     * Get model id
     *
     * @return string Model id
     */
    public function getId()
    {
        return static::MODEL_ID;
    }

    /**
     * Get model name
     *
     * @return string Model name
     */
    public function getName()
    {
        return static::MODEL_NAME;
    }

    /**
     * Can retain state?
     *
     * @return bool True if can, false if not
     */
    public function canRetainState()
    {
        return static::CAN_RETAIN_STATE;
    }

    /**
     * To string.
     *
     * @return string Model name
     */
    public function __toString()
    {
        return $this->getName();
    }
}
