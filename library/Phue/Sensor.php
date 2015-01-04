<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

use Phue\SensorModel\SensorModelFactory;

/**
 * Sensor object
 */
class Sensor
{
    /**
     * Id
     *
     * @var int
     */
    protected $id;

    /**
     * Sensor attributes
     *
     * @var \stdClass
     */
    protected $attributes;

    /**
     * Phue client
     *
     * @var Client
     */
    protected $client;

    /**
     * Construct a Phue Sensor object
     *
     * @param string    $id         Id
     * @param \stdClass $attributes Sensor attributes
     * @param Client    $client     Phue client
     */
    public function __construct($id, \stdClass $attributes, Client $client)
    {
        $this->id         = $id;
        $this->attributes = $attributes;
        $this->client     = $client;
    }

    /**
     * Get sensor Id
     *
     * @return int Sensor id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get assigned name of sensor
     *
     * @return string Name of sensor
     */
    public function getName()
    {
        return $this->attributes->name;
    }

    /**
     * Get type
     *
     * @return string Type of sensor
     */
    public function getType()
    {
        return $this->attributes->type;
    }

    /**
     * Get model id
     *
     * @return string Model id
     */
    public function getModelId()
    {
        return $this->attributes->modelid;
    }

    /**
     * Get model
     *
     * @return AbstractSensorModel Sensor model
     */
    public function getModel()
    {
        return SensorModelFactory::build($this->getModelId());
    }

    /**
     * Get manufacturer name
     *
     * @return string Manufacturer name
     */
    public function getManufacturerName()
    {
        return $this->attributes->manufacturername;
    }

    /**
     * Get software version
     *
     * @return string|null Software version
     */
    public function getSoftwareVersion()
    {
        if (isset($this->attributes->swversion)) {
            return $this->attributes->swversion;
        }

        return null;
    }

    /**
     * Get unique id
     *
     * @return string|null Unique id
     */
    public function getUniqueId()
    {
        if (isset($this->attributes->uniqueid)) {
            return $this->attributes->uniqueid;
        }

        return null;
    }

    /**
     * Get state
     *
     * @return \stdClass State
     */
    public function getState()
    {
        return (object) $this->attributes->state;
    }

    /**
     * Get config
     *
     * @return \stdClass Config
     */
    public function getConfig()
    {
        return (object) $this->attributes->config;
    }

    /**
     * __toString
     *
     * @return string Sensor Id
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
