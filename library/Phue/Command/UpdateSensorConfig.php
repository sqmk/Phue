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
 * Update sensor config command
 */
class UpdateSensorConfig extends CreateSensor
{
    /**
     * Sensor Id
     *
     * @var string
     */
    protected $sensorId;

    /**
     * Sensor config
     *
     * @var array
     */
    protected $config = [];

    /**
     * Constructs a command
     *
     * @param mixed $sensor Sensor Id or Sensor object
     */
    public function __construct($sensor)
    {
        $this->sensorId = (string) $sensor;
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
     */
    public function send(Client $client)
    {
        $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/sensors/{$this->sensorId}/config",
            TransportInterface::METHOD_PUT,
            (object) $this->config
        );
    }
}
