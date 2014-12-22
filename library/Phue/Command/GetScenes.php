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
use Phue\Scene;

/**
 * Get scenes command
 */
class GetScenes implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return Scene[] List of Scene objects
     */
    public function send(Client $client)
    {
        // Get response
        $results = $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/scenes"
        );

        $scenes = [];

        foreach ($results as $sceneId => $attributes) {
            $scenes[$sceneId] = new Scene($sceneId, $attributes, $client);
        }

        return $scenes;
    }
}
