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
use Phue\Schedule;

/**
 * Get schedules command
 */
class GetSchedules implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return Schedule[] List of Schedule objects
     */
    public function send(Client $client)
    {
        // Get response
        $response = $client->getTransport()->sendRequest(
            $client->getUsername()
        );

        // Return empty list if no schedules
        if (!isset($response->schedules)) {
            return [];
        }

        $schedules = [];

        foreach ($response->schedules as $scheduleId => $attributes) {
            $schedules[$scheduleId] = new Schedule($scheduleId, $attributes, $client);
        }

        return $schedules;
    }
}
