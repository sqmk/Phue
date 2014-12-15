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
use Phue\Light;

/**
 * Get lights command
 */
class GetLights implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return Light[] List of Light objects
     */
    public function send(Client $client)
    {
        // Get response
        $response = $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/lights"
        );

        $lights = [];

        foreach ($response as $lightId => $attributes) {
            $lights[$lightId] = new Light($lightId, $attributes, $client);
        }

        return $lights;
    }
}
