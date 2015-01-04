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
 * Update sensor state command
 */
class UpdateSensorState extends CreateSensor
{
    /**
     * Sensor Id
     *
     * @var string
     */
    protected $sensorId;

    /**
     * Sensor state
     *
     * @var array
     */
    protected $state = [];

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
     * Send command
     *
     * @param Client $client Phue Client
     */
    public function send(Client $client)
    {
        $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/sensors/{$this->sensorId}/state",
            TransportInterface::METHOD_PUT,
            (object) $this->state
        );
    }
}
