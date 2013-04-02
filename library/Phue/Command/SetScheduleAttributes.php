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
 * Set schedule attributes command
 */
class SetScheduleAttributes extends CreateSchedule implements CommandInterface
{
    /**
     * Schedule Id
     *
     * @var string
     */
    protected $scheduleId;

    /**
     * Constructs a command
     *
     * @param mixed $schedule Schedule Id or Schedule object
     */
    public function __construct($schedule)
    {
        $this->scheduleId = (string) $schedule;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     */
    public function send(Client $client)
    {
        // Set command attribute if passed
        if ($this->command) {
            $this->attributes['command'] = $this->command->getSchedulableParams($client);
        }

        $client->getTransport()->sendRequest(
            "{$client->getUsername()}/schedules/{$this->scheduleId}",
            TransportInterface::METHOD_PUT,
            (object) $this->attributes
        );
    }
}
