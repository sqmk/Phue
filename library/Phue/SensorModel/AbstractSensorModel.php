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
 * Abstract sensor model
 */
abstract class AbstractSensorModel
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
     * To string.
     *
     * @return string Model name
     */
    public function __toString()
    {
        return $this->getName();
    }
}
