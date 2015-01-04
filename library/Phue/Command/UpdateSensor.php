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
 * Update sensor command
 */
class UpdateSensor extends CreateSensor
{
    /**
     * Sensor Id
     *
     * @var string
     */
    protected $sensorId;

    /**
     * Sensor attributes
     *
     * @var array
     */
    protected $attributes = [];

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
     * Send command
     *
     * @param Client $client Phue Client
     */
    public function send(Client $client)
    {
        $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/sensors/{$this->sensorId}",
            TransportInterface::METHOD_PUT,
            (object) $this->attributes
        );
    }
}
