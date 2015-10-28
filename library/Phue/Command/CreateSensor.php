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
 * Create sensor command
 */
class CreateSensor implements CommandInterface
{
    /**
     * Sensor attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Sensor state
     *
     * @var array
     */
    protected $state = [];

    /**
     * Config
     *
     * @var array
     */
    protected $config = [];

    /**
     * Constructs a command
     *
     * @param string $name Name
     */
    public function __construct($name = null)
    {
        $this->name($name);
    }

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return self This object
     */
    public function name($name)
    {
        $this->attributes['name'] = (string) $name;

        return $this;
    }

    /**
     * Set model Id
     *
     * @param string $modelId Model Id
     *
     * @return self This object
     */
    public function modelId($modelId)
    {
        $this->attributes['modelid'] = (string) $modelId;

        return $this;
    }

    /**
     * Set software version
     *
     * @param string $softwareVersion Software version
     *
     * @return self This object
     */
    public function softwareVersion($softwareVersion)
    {
        $this->attributes['swversion'] = (string) $softwareVersion;

        return $this;
    }

    /**
     * Set type
     *
     * @param string $type Type of sensor
     *
     * @return self This object
     */
    public function type($type)
    {
        $this->attributes['type'] = (string) $type;

        return $this;
    }

    /**
     * Set unique Id
     *
     * @param string $uniqueId Unique Id
     *
     * @return self This object
     */
    public function uniqueId($uniqueId)
    {
        $this->attributes['uniqueid'] = (string) $uniqueId;

        return $this;
    }

    /**
     * Set manufacturer name
     *
     * @param string $manufacturerName Manufacturer name
     *
     * @return self This object
     */
    public function manufacturerName($manufacturerName)
    {
        $this->attributes['manufacturername'] = (string) $manufacturerName;

        return $this;
    }

    /**
     * State attribute
     *
     * @param string $key   Key
     * @param mixed  $value Value
     *
     * @return self This object
     */
    public function stateAttribute($key, $value)
    {
        $this->state[$key] = $value;

        return $this;
    }

    /**
     * Config attribute
     *
     * @param string $key   Key
     * @param mixed  $value Value
     *
     * @return self This object
     */
    public function configAttribute($key, $value)
    {
        $this->config[$key] = $value;

        return $this;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return int Sensor Id
     */
    public function send(Client $client)
    {
        $response = $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/sensors",
            TransportInterface::METHOD_POST,
            (object) array_merge(
                $this->attributes,
                [
                    'state'  => $this->state,
                    'config' => $this->config,
                ]
            )
        );

        return $response->id;
    }
}
