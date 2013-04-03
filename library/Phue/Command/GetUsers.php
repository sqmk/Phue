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
use Phue\User;

/**
 * Get users command
 */
class GetUsers implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return array List of User objects
     */
    public function send(Client $client)
    {
        // Get response
        $response = $client->getTransport()->sendRequest(
            "{$client->getUsername()}/config"
        );

        // Return empty list if no users
        if (!isset($response->whitelist)) {
            return [];
        }

        $users = [];

        foreach ($response->whitelist as $username => $attributes) {
            $users[$username] = new User($username, $attributes, $client);
        }

        return $users;
    }
}
