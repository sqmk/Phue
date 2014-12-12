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
 * Create schedule command
 */
class CreateSchedule implements CommandInterface
{
    /**
     * Schedule attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Command
     *
     * @var SchedulableInterface
     */
    protected $command;

    /**
     * Constructs a create schedule command
     *
     * @param string                $name    Name of schedule
     * @param string                $time    Time to run command
     * @param SchedulableInterface  $command Schedulable command
     */
    public function __construct(
        $name = null,
        $time = null,
        SchedulableInterface $command = null
    ) {
        // Set name, time, command if passed
        $name    !== null && $this->name($name);
        $time    !== null && $this->time($time);
        $command !== null && $this->command($command);

        // Copy description
        $this->description = $name;
    }

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return CreateSchedule Self object
     */
    public function name($name)
    {
        $this->attributes['name'] = (string) $name;

        return $this;
    }

    /**
     * Set description
     *
     * @param string $description Description
     *
     * @return CreateSchedule Self object
     */
    public function description($description)
    {
        $this->attributes['description'] = (string) $description;

        return $this;
    }

    /**
     * Set time
     *
     * @param string $time Time
     *
     * @return CreateSchedule Self object
     */
    public function time($time)
    {
        $this->attributes['time'] = $this->convertTimeToUtcDate(
            (string) $time
        );

        return $this;
    }

    /**
     * Set command
     *
     * @param SchedulableInterface $command Schedulable command
     *
     * @return CreateSchedule Self object
     */
    public function command(SchedulableInterface $command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return int Group Id
     */
    public function send(Client $client)
    {
        // Set command attribute if passed
        if ($this->command) {
            $this->attributes['command'] = $this->command->getSchedulableParams($client);
        }

        // Create schedule
        $scheduleId = $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/schedules",
            TransportInterface::METHOD_POST,
            (object) $this->attributes
        );

        return $scheduleId;
    }

    /**
     * Convert time to UTC date
     *
     * @param string $time Time to convert
     * @throws \InvalidArgumentException
     * @return string
     */
    public function convertTimeToUtcDate($time)
    {
        try {
            $setTime = (new \DateTime($time))
                ->setTimeZone(new \DateTimeZone('UTC'));
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('time value could not be parsed');
        }

        return $setTime->format('Y-m-d\TH:i:s');
    }
}
