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
use Phue\TimePattern\AbsoluteTime;
use Phue\TimePattern\TimePatternInterface;
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
     * @var ActionableInterface
     */
    protected $command;

    /**
     * Time pattern
     *
     * @var TimePatternInterface
     */
    protected $time;

    /**
     * Constructs a create schedule command
     *
     * @param string              $name    Name of schedule
     * @param mixed               $time    Time to run command
     * @param ActionableInterface $command Actionable command
     */
    public function __construct(
        $name = null,
        $time = null,
        ActionableInterface $command = null
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
     * @return self This object
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
     * @return self This object
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
     * @return self This object
     */
    public function time($time)
    {
        if (!($time instanceof TimePatternInterface)) {
            $time = new AbsoluteTime((string) $time);
        }

        $this->time = $time;

        return $this;
    }

    /**
     * Set command
     *
     * @param ActionableInterface $command Actionable command
     *
     * @return self This object
     */
    public function command(ActionableInterface $command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Set status
     *
     * @return string $status Status
     *
     * @return self This object
     */
    public function status($status)
    {
        $this->attributes['status'] = (string) $status;

        return $this;
    }

    /**
     * Set autodelete
     *
     * @param bool $flag Flag
     *
     * @return self This object
     */
    public function autodelete($flag)
    {
        $this->attributes['autodelete'] = (bool) $flag;

        return $this;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return int Schedule Id
     */
    public function send(Client $client)
    {
        // Set command attribute if passed
        if ($this->command) {
            $params            = $this->command->getActionableParams($client);
            $params['address'] = "/api/{$client->getUsername()}" . $params['address'];

            $this->attributes['command'] = $params;
        }

        // Set time attribute if passed
        if ($this->time) {
            $this->attributes['time'] = (string) $this->time;
        }

        // Create schedule
        $scheduleId = $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/schedules",
            TransportInterface::METHOD_POST,
            (object) $this->attributes
        );

        return $scheduleId;
    }
}
