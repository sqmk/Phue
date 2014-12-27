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
 * Sensor model factory
 */
class SensorModelFactory
{
    /**
     * Build a new sensor model from model id
     *
     * @param string $modelId Model id
     *
     * @return AbstractSensorModel Sensor model
     */
    public static function build($modelId)
    {
        $classNamePrefix = __NAMESPACE__ . '\\';
        $classNameModel  = ucfirst(strtolower($modelId)) . 'Model';

        if (!class_exists($classNamePrefix . $classNameModel)) {
            $classNameModel = 'UnknownModel';
        }

        $finalClassName = $classNamePrefix . $classNameModel;

        return new $finalClassName;
    }
}
