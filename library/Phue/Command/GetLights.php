<?php

namespace Phue\Command;

use Phue\Client,
    Phue\Command\CommandInterface,
    Phue\Light;

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
     * @return array List of Light objects
     */
    public function send(Client $client)
    {
        // Get response
        $response = $client->getTransport()->sendRequest(
            'GET',
            "{$client->getUsername()}"
        );

        // Return empty list if no lights
        if (!isset($response->lights)) {
            return [];
        }

        $lights = [];

        foreach ($response->lights as $lightId => $details) {
            $lights[$lightId] = new Light($lightId, $details);   
        }

        return $lights;
    }
}
