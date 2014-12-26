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
use Phue\Sensor;

/**
 * Get sensors command
 */
class GetSensors implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return Sensor[] List of Sensor objects
     */
    public function send(Client $client)
    {
        // Get response
        $results = $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/sensors"
        );

        $sensors = [];

        foreach ($results as $sensorId => $attributes) {
            $sensors[$sensorId] = new Sensor($sensorId, $attributes, $client);
        }

        return $sensors;
    }
}
