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
use Phue\Command\CommandInterface;
use Phue\Group;

/**
 * Get groups command
 *
 * @category Phue
 * @package  Phue
 */
class GetGroups implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return array List of Group objects
     */
    public function send(Client $client)
    {
        // Get response
        $response = $client->getTransport()->sendRequest(
            $client->getUsername()
        );

        // Return empty list if no groups
        if (!isset($response->groups)) {
            return [];
        }

        $groups = [];

        foreach ($response->groups as $groupId => $details) {
            $groups[$groupId] = new Group($groupId, $details, $client);
        }

        return $groups;
    }
}
