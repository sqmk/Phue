<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace Phue\Command;

use Phue\Client;
use Phue\Transport\Http;
use Phue\Command\CommandInterface;
use Phue\Light;

/**
 * Get lights command
 *
 * @category Phue
 * @package  Phue
 */
class GetLights implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return array List of Light objects
     */
    public function send(Client $client)
    {
        // Get response
        $response = $client->getTransport()->sendRequest(
            $client->getUsername()
        );

        // Return empty list if no lights
        if (!isset($response->lights)) {
            return [];
        }

        $lights = [];

        foreach ($response->lights as $lightId => $details) {
            $lights[$lightId] = new Light($lightId, $details, $client);
        }

        return $lights;
    }
}
