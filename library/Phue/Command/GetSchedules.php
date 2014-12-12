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
            "/api/{$client->getUsername()}/schedules"
        );

        $schedules = [];

        foreach ($response as $scheduleId => $attributes) {
            $schedules[$scheduleId] = new Schedule($scheduleId, $attributes, $client);
        }

        return $schedules;
    }
}
